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

}