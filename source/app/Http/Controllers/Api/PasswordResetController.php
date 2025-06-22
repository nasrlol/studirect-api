<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportException;

class PasswordResetController extends Controller
{

    public function sendResetStudentPassword(MailService $mailService, string $id): JsonResponse
    {
        $student = Student::findOrFail($id);

        try {
            $mailService->sendStudentPasswordReset($student);
            return response()->json(['message' => 'Reset password mail send successfully']);
        } catch (TransportException $e) {
            return response()->json(['message' => 'Failed to send reset password mail']);
        }
    }
}

