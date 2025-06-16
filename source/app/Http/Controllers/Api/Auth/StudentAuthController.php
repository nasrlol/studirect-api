<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentAuthController extends Controller
{
    public function login(Request $request, LogService $logService): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $logService->setLog("Student", "Student logged in", "Auth");
        
        return response()->json([
            'user' => $student,
            'token' => $student->createToken('student-token')->plainTextToken,
            'user_type' => 'student'
        ]);
    }

    public function logout(Request $request, LogService $logService): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        
        $logService->setLog("Student", "Student logged out", "Auth");
        
        return response()->json(['message' => 'Logged out successfully']);
    }
}