<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Student;
use App\Models\Company;

class AdminController extends Controller
{
    public function index(): JsonResponse
    {
        $admins = Admin::all();
        return response()->json(['data' => $admins]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $admin = Admin::create($validated);

        return response()->json(['data' => $admin], 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);
            return response()->json(['data' => $admin]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);
            $validated = $request->validate([
                'email' => 'email|unique:admins,email,' . $admin->id,
                'password' => 'nullable|string|min:8',
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $admin->update($validated);

            return response()->json(['data' => $admin]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();
            return response()->json(['message' => 'Admin verwijderd']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }


    // Studenten beheren
    public function getAllStudents(): JsonResponse
    {
        $students = Student::all();
        return response()->json(['data' => $students]);
    }

    public function getStudent(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json(['data' => $student]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student niet gevonden'], 404);
        }
    }

    public function updateStudent(Request $request, string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validated = $request->validate([
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'email|unique:students,email,' . $student->id,
                'study_direction' => 'string|max:255',
                'graduation_track' => 'string|max:255',
                'interests' => 'string',
                'job_preferences' => 'string',
                'profile_complete' => 'boolean',
            ]);

            $student->update($validated);

            // Log de admin actie
            $this->logAdminAction('update', 'Student', $id, 'info');

            return response()->json([
                'data' => $student,
                'message' => 'Student is bijgewerkt'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student niet gevonden'], 404);
        }
    }

    public function deleteStudent(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            // Log de admin actie
            $this->logAdminAction('delete', 'Student', $id, 'warning');

            return response()->json(['message' => 'Student verwijderd']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student niet gevonden'], 404);
        }
    }

// Bedrijven beheren
    public function getAllCompanies(): JsonResponse
    {
        $companies = Company::all();
        return response()->json(['data' => $companies]);
    }

    public function getCompany(string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            return response()->json(['data' => $company]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Bedrijf niet gevonden'], 404);
        }
    }


    private function logAdminAction(string $action, string $targetType, string $targetId, string $severity = 'info'): void
    {
        // In een echte toepassing zou je hier de huidige ingelogde admin ID gebruiken
        // Voor nu gebruiken we ID 1 als voorbeeld
        $adminId = 1; // Hier zou je Auth::id() of iets dergelijks gebruiken

        Admin::create([
            'admin_id' => $adminId,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'severity' => $severity,
            // timestamp wordt automatisch ingevuld door de database
        ]);
    }

    public function updateCompany(Request $request, string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $validated = $request->validate([
                'name' => 'string|max:255',
                'email' => 'email|unique:companies,email,' . $company->id,
                'plan_type' => 'string|max:255',
                'description' => 'string',
                'job_types' => 'string',
                'job_domain' => 'string',
                'booth_location' => 'string|max:255',
                'photo' => 'string|max:255',
                'speeddate_duration' => 'integer'
            ]);

            $company->update($validated);

            // Log de admin actie
            $this->logAdminAction('update', 'Company', $id, 'info');

            return response()->json([
                'data' => $company,
                'message' => 'Bedrijf is bijgewerkt'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Bedrijf niet gevonden'], 404);
        }
    }

    public function deleteCompany(string $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            // Log de admin actie
            $this->logAdminAction('delete', 'Company', $id, 'warning');

            return response()->json(['message' => 'Bedrijf verwijderd']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Bedrijf niet gevonden'], 404);
        }
    }


    public function createCompany(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required|string|min:8',
            'plan_type' => 'required|string|max:255',
            'description' => 'required|string',
            'job_types' => 'required|string',
            'job_domain' => 'required|string',
            'booth_location' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'speeddate_duration' => 'nullable|integer',
        ]);

        $company = Company::create($validated);
        
        // Log de admin actie
        $this->logAdminAction('create', 'Company', $company->id, 'info');
        
        return response()->json([
            'data' => $company,
            'message' => 'Bedrijf is aangemaakt'
        ], 201);
    }


}

