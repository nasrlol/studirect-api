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
}
