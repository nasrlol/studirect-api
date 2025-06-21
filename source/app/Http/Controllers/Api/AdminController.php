<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\LogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(): JsonResponse
    {

        $admins = Admin::all();

        $this->authorize("viewAny", Admin::class);
        return response()->json(['data' => $admins]);
    }

    public function store(Request $request, LogService $logService): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',         // Een wachtwoord van minimum 8 tekens
            'profile_photo' => 'nullable|string|max:255',  // Add validation for profile photo
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $this->authorize("create", Admin::class);
        $admin = Admin::create($validated);

        $logService->setLog("Admin", $admin->id, "Admin created ", "Admin", LogLevel::CRITICAL);

        return response()->json(['data' => $admin], 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);
            $this->authorize("view", $admin);
            return response()->json(['data' => $admin]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }

    public function update(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);
            $validated = $request->validate([
                'email' => 'email|unique:admins,email,' . $admin->id,
                'password' => 'nullable|string|min:8',
                'profile_photo' => 'nullable|string|max:255',  // Add validation for profile photo
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $this->authorize("update", $admin);
            $admin->update($validated);
            $logService->setLog("Admin", $admin->id, "Admin updated ", "Admin", LogLevel::CRITICAL);

            return response()->json(['data' => $admin]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }

    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);

            $this->authorize("delete", $admin);
            $admin->delete();
            $logService->setLog("Admin", $admin->id, "Admin deleted ", "Admin", LogLevel::CRITICAL);

            return response()->json(['message' => 'Admin verwijderd']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }
}
