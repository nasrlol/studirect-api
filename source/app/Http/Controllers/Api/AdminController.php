<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function index(): JsonResponse
    {
        $admins = Admin::all();
        return response()->json(['data' => $admins]);
    }

    public function store(Request $request, LogService $logService): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $admin = Admin::create($validated);

        $logService->setLog("Admin", $admin->id, "Admin created ", "Admin", LogLevel::CRITICAL);

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

    public function update(Request $request, string $id, LogService $logService): JsonResponse
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
            $logService->setLog("Admin", $admin->id, "Admin updated ", "Admin");
            // severity level wordt hier niet gezet omdat ik dat als default waarde heb gezet, dus normal = niks doen


            return response()->json(['data' => $admin]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }

    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $admin = Admin::findOrFail($id);

            $admin->delete();
            $logService->setLog("Admin",$admin->id, "Admin deleted ", "Admin", LogLevel::CRITICAL);

            return response()->json(['message' => 'Admin verwijderd']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Admin niet gevonden'], 404);
        }
    }
}
