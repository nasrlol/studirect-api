<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'booth_location' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'job_types' => 'nullable|string|max:255',
            'job_domain' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'nullable|integer|max:60'
        ]);

        // Standaardwaarden voor ontbrekende velden
        $defaults = [
            'description' => 'Bedrijfsbeschrijving nog niet ingevuld',
            'job_types' => 'Fulltime',
            'job_domain' => 'Nog niet gespecificeerd',
            'photo' => null,
            'speeddate_duration' => 30
        ];

        // Vul ontbrekende velden aan met standaardwaarden
        foreach ($defaults as $field => $value) {
            if (!isset($validate[$field])) {
                $validate[$field] = $value;
            }
        }

        $company = Company::create($validate);

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
    public function update(Request $request, string $id) : JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' .$company->id,
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'job_types' => 'required|string|max:255',
            'job_domain' => 'required|string|max:255',
            'booth_location' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'required|integer|max:60'
            ]);

            $company->update($validated);

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
    public function destroy(string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            return response()->json([
                'message' => 'Company deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }
}
