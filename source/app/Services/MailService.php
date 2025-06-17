<?php

namespace App\Services;


use App\Mail\AppointmentMail;
use App\Mail\CompanyAccountCreation;
use App\Mail\StudentProfileVerification;
use App\Mail\StudentResetPassword;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

// controllers dienen voor het maken van routes
// services dat een logische bewerking encapsuleert en die dan implementeert
class MailService
{
    public function sendStudentVerification(Student $student): void
    {
        try {
            Mail::to($student->email)->send(new StudentProfileVerification($student));
            // gebruikte hiervoor de gewone exception maar voor mail dinges is transportexceptioninterface
        } catch (TransportException $e)
        {
            // logs service at the moment its still in the controller and i dont want to write code that im going to have to delete later
        }
    }

    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        try {
            Mail::to($appointment->student->email)->send(new AppointmentMail($appointment));
        } catch (TransportException $e)
        {
            // logs service at the moment its still in the controller and i dont want to write code that im going to have to delete later
        }
    }

    public function sendCompanyAccountVerification(Company $company): void
    {
        try {
            Mail::to($company->email)->send(new CompanyAccountCreation($company));
        } catch (TransferException $e)
        {
            // logs service at the moment its still in the controller and i dont want to write code that im going to have to delete later
        }

    }

    public function sendStudentPasswordReset(Student $student): void
    {
        try {
            Mail::to($student->email)->send(new StudentResetPassword($student));
        } catch (TransferException $e)
        {
            // doe ik later nog wel
        }
    }

}
