<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Exception\TransportException;

class PasswordResetController extends Controller
{

    public function sendResetStudentPassword(MailService $mailService, Request $request): JsonResponse
    {
        $validate = $request->validate([
            'email' => 'required|email|exists:students,email',
        ]);

        $student = Student::where('email', $validate['email'])->firstOrFail();
        try {
            $mailService->sendStudentPasswordReset($student);
            return response()->json(['message' => 'Reset password mail send successfully']);
        } catch (TransportException $e) {
            return response()->json(['message' => 'Failed to send reset password mail']);
        }
    }
}

