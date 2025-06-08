<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companys = Company::all();

        return response()->json([
            'data'=>$companys
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companys,email',
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'job_types' => 'required|string|max:255',
            'job_domain' => 'required|string|max:255',
            'booth_location' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'required|integer|max:60'
        ]);

        $company = Company::create($validate);

        return response()->json([
            'data' => $company,
            'message' => 'Student created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
        try {

            $company = Company::findOrFail($id);
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companys,email',
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
                'message' => 'Goed gedaan manneke successfully'
            ]);
        } catch (ModelNotFoundException $e)
        {
            return response()->json(['message' => 'Toemme niet gevonden unsuccessfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            return response()->json([
                'message' => 'Student deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}
