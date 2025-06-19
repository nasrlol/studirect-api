<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $student = Student::where('email', $request->email)->first();
        if ($student && Hash::check($request->password, $student->password)) {
            return response()->json([
                'type' => 'student',
                'id' => $student->id,
                'token' => 'mock-token'
            ]);
        }

        $company = Company::where('email', $request->email)->first();
        if ($company && Hash::check($request->password, $company->password)) {
            return response()->json([
                'type' => 'company',
                'id' => $company->id,
                'token' => 'mock-token'
            ]);
        }

        return response()->json(['error' => 'Inloggegevens zijn onjuist'], 401);
    }
}
