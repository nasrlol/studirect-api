<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\LogService;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * dus een lijst van alle companies die we hebben in de db
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();
        return response()->json([
            'data'=>$companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, MailService $mailService, LogService $logService): JsonResponse
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'booth_location' => 'required|string|max:255',
            'job_types' => 'nullable|string|max:255',
            'job_domain' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'nullable|integer|max:60',
            'job_requirements' => 'nullable|string',
            'job_description' => 'nullable|string',
            'company_description' => 'nullable|string',
            'company_location' => 'nullable|string|max:255'
        ]);

        // Standaardwaarden voor ontbrekende velden
        $defaults = [
            'job_types' => 'Fulltime',
            'job_domain' => 'Nog niet gespecificeerd',
            'photo' => null,
            'speeddate_duration' => 30,
            'job_requirements' => 'Functie-eisen nog niet ingevuld',
            'job_description' => 'Functieomschrijving nog niet ingevuld',
            'company_description' => 'Bedrijfsbeschrijving nog niet ingevuld'
        ];

        // Vul ontbrekende velden aan met standaardwaarden
        foreach ($defaults as $field => $value) {
            if (!isset($validate[$field])) {
                $validate[$field] = $value;
            }
        }

        $company = Company::create($validate);

        $logService->setLog("Company", $company->id, "Company created", "Company", LogLevel::CRITICAL);
        $mailService->sendCompanyAccountVerification($company, $logService);

        return response()->json([
            'data' => $company,
            'message' => 'Company created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            return response()->json(['data'=>$company]);
        } catch(ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Company not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, LogService $logService) : JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' .$company->id,
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'job_types' => 'required|string|max:255',
            'job_domain' => 'required|string|max:255',
            'booth_location' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'required|integer|max:60'
            ]);

            $company->update($validated);
            $logService->setLog("Company", $company->id, "Company updated", "Company", LogLevel::CRITICAL);

            return response()->json([
                'data' => $company,
                'message' => 'Company updated successfully'
            ]);
        } catch (ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Company not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            $logService->setLog("Company", $company->id, "Company deleted", "Company", LogLevel::CRITICAL);

            return response()->json([
                'message' => 'Company deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }

    public function partialUpdate(Request $request, string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);

            $fields = [
                'name',
                'email',
                'password',
                'plan_type',
                'job_types',
                'job_domain',
                'booth_location',
                'photo',
                'speeddate_duration',
                'company_description',
                'job_title',
                'job_requirements',
                'job_description',
                'company_location'
                ];


            // filtreren op enkel de informatie dat meegegeven wordt
            $data = $request->only($fields);

            // het wachtwoord opnieuw hashen
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $company->update($data);
            return response()->json([
                'data' => $company,
                'message' => 'Company partially updated successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }
}
