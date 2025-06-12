<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentMail;
use App\Mail\StudentVerification;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;


class MailController extends Controller
{
    public function sendStudentVerification(int $id): JsonResponse
    {
        $student = Student::findOrFail($id);

        try {
            Mail::to($student->email)->send(new StudentVerification($student));
            return response()->json(['message' => 'Verification mail sent']);
        } catch (Exception $e)
        {
            return response()->json([
                'message' => 'Failed to send verification email.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function appointmentConfirmation(Appointment $appointment): JsonResponse
    {
        $student = Student::findOrFail($appointment->student_id);

        try {
            Mail::to($student->email)->send(new AppointmentMail($appointment));
            return response()->json(['message' => 'Appointment confirmation mail sent']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send confirmation email.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
