<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\StudentVerification;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //

    public function sendStudentVerification(Request $request){

        $request->validate([
            'id' => 'required|integer|exists:students,id',
        ]);
        // nakijken of de request wel degelijk de juiste data meegeeft

        $student = Student::findOrFail($request->id);

        Mail::to("studirect@nsrddyn.com")->send(new StudentVerification($student));
        return response()->json(['message' => 'Verification mail sent']);
    }
}
