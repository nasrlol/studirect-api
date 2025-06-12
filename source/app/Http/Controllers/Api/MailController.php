<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CompanyPassword;
use App\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function companyPassword(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);

        try {
            Mail::to($company->email)->send(new CompanyPassword($company));
            return response()->json(['message' => 'Verification mail sent']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send verification email.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
