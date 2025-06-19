<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\LogService;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mailer\Exception\TransportException;

class PasswordResetController extends Controller
{

    public function sendResetStudentPassword(Student $student, MailService $mailService): JsonResponse
    {
        try {
            $mailService->sendStudentPasswordReset($student);
            return response()->json(['message' => 'Reset password mail send successfully']);
        } catch (TransportException $e)
        {
            return response()->json(['message' => 'Failed to send reset password mail']);
        }
    }
    public function resetStudentPassword(Request $request, string $id, LogService $logService): JsonResponse
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8'
        ]);

        try {
            $student = Student::findOrFail($id);
            $student->password = Hash::make($validated['password']);
            $student->save();

            $logService->setLog("Student", $student->id, "change password", "Student");
            return response()->json([
                'message' => 'Student password changed successfully',
            ]);

        } catch (ModelNotFoundException $e)
        {
            return response()->json(['message'=> 'Student not found'], 404);
        }
    }
}

