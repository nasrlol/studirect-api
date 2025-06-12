<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StudentVerification;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;


class MailController extends Controller
{
    public function studentVerification(int $id): JsonResponse
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


    public function companyPassword(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);

        try {
            Mail::to($company->email)->send(new StudentVerification($company));
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
