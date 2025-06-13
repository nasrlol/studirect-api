<?php

namespace App\Services;


use App\Mail\AppointmentMail;
use App\Mail\CompanyPassword;
use App\Mail\StudentVerification;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;

// controllers dienen voor het maken van routes
// services dat een logische bewerking encapsuleert en die dan implementeert
class MailService
{
    public function sendStudentVerification(Student $student): void
    {
        Mail::to($student->email)->send(new StudentVerification($student));
    }

    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        Mail::to($appointment->student->email)->send(new AppointmentMail($appointment));
    }

    public function sendCompanyPassword(Company $company): void
    {
        Mail::to($company->email)->send(new CompanyPassword($company));
    }

}
