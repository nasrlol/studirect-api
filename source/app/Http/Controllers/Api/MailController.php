<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StudentVerification;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;


class MailController extends Controller
{
    public function sendStudentVerification(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:students,id',
        ]);
        // nakijken of de request wel degelijk de juiste data meegeeft

        $student = Student::findOrFail($request->id);

        try {
            Mail::to('nsrddynlptp@gmail.com')->send(new StudentVerification($student));
            //Mail::to($student->email)->send(new StudentVerification($student));

            return response()->json(['message' => 'Verification mail sent']);
        } catch (Exception $e)
        {
            return response()->json([
                'message' => 'Failed to send verification email.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
