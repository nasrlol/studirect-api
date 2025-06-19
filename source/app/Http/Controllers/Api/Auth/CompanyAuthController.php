<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Enums\LogLevel;

class CompanyAuthController extends Controller
{
    public function login(Request $request, LogService $logService): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $company = Company::where('email', $request->email)->first();

        if (! $company || ! Hash::check($request->password, $company->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $logService->setLog("Company", $company->id, "Company logged in", "Auth", LogLevel::NORMAL);

        
        return response()->json([
            'user' => $company,
            'token' => $company->createToken('company-token', ['company'])->plainTextToken,
            'user_type' => 'company'
        ]);
    }

    public function logout(Request $request, LogService $logService): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        $logService->setLog("Company", $request->user()->id, "Company logged out", "Auth", LogLevel::NORMAL);

        return response()->json(['message' => 'Logged out successfully']);
    }
}