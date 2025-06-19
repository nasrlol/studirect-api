<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Enums\LogLevel;

class AdminAuthController extends Controller
{
    public function login(Request $request, LogService $logService): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $logService->setLog("Admin", $admin->id, "Admin logged in", "Auth", LogLevel::NORMAL);
       
        return response()->json([
            'user' => $admin,
            'token' => $admin->createToken('admin-token', ['admin'])->plainTextToken,
            'user_type' => 'admin'
        ]);
    }

    public function logout(Request $request, LogService $logService): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        

        $logService->setLog("Admin", $request->user()->id, "Admin logged out", "Auth", LogLevel::NORMAL);
        
        return response()->json(['message' => 'Logged out successfully']);
    }
} 