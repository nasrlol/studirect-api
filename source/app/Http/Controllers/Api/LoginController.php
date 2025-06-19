<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Student;
use App\Services\LogService;
use App\Enums\LogLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle unified login for both students and companies
     *
     * @param Request $request
     * @param LogService $logService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request, LogService $logService): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Try student login
        $student = Student::where('email', $request->email)->first();
        if ($student) {
            if (Hash::check($request->password, $student->password)) {
                // Log successful student login
                try {
                    $logService->setLog(
                        actor: "Student",
                        actor_id: $student->id,
                        action: "Student logged in",
                        targetType: "Auth"
                    );
                } catch (\Exception $e) {
                    // Continue even if logging fails
                    report($e);
                }
                
                return response()->json([
                    'user' => $student,
                    'token' => $student->createToken('student-token', ['student'])->plainTextToken,
                    'user_type' => 'student'
                ]);
            }
        }

        // Try company login
        $company = Company::where('email', $request->email)->first();
        if ($company) {
            if (Hash::check($request->password, $company->password)) {
                // Log successful company login
                try {
                    $logService->setLog(
                        actor: "Company",
                        actor_id: $company->id,
                        action: "Company logged in",
                        targetType: "Auth"
                    );
                } catch (\Exception $e) {
                    // Continue even if logging fails
                    report($e);
                }
                
                return response()->json([
                    'user' => $company,
                    'token' => $company->createToken('company-token', ['company'])->plainTextToken,
                    'user_type' => 'company'
                ]);
            }
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Log out the authenticated user
     *
     * @param Request $request
     * @param LogService $logService
     * @return JsonResponse
     */
    public function logout(Request $request, LogService $logService): JsonResponse
    {
        $user = $request->user();
        $userType = null;
        $userId = null;
        
        if ($user instanceof Student) {
            $userType = 'Student';
            $userId = $user->id;
        } elseif ($user instanceof Company) {
            $userType = 'Company';
            $userId = $user->id;
        }
        
        // Delete the current token
        $request->user()->currentAccessToken()->delete();
        
        // Log the logout if we identified the user type
        if ($userType && $userId) {
            try {
                $logService->setLog(
                    actor: $userType,
                    actor_id: $userId,
                    action: "$userType logged out",
                    targetType: "Auth"
                );
            } catch (\Exception $e) {
                // Continue even if logging fails
                report($e);
            }
        }
        
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}