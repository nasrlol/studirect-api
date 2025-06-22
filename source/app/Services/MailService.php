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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

// controllers dienen voor het maken van routes
// services dat een logische bewerking encapsuleert en die dan implementeert
class MailService
{
    public function sendStudentVerification(Student $student, LogService $logService): void
    {
        try {
            Mail::to($student->email)->send(new StudentProfileVerification($student));
            // gebruikte hiervoor de gewone exception maar voor mail dinges is transportexceptioninterface
        } catch (TransportException $e) {
            $logService->setLog("Student", $student->id, $e, "Student");
        }
    }

    public function sendAppointmentConfirmation(Appointment $appointment, LogService $logService): void
    {
        try {
            Mail::to($appointment->student->email)->send(new AppointmentMail($appointment));
        } catch (TransportException $e) {
            $logService->setLog("Student", $appointment->student_id, $e, "Appointment");
        }
    }

    public function sendCompanyAccountVerification(Company $company, LogService $logService): void
    {
        try {
            Mail::to($company->email)->send(new CompanyAccountCreation($company));
        } catch (TransferException $e) {
            $logService->setLog("Company", $company->id, $e, "Company");
        }

    }

    public function sendStudentPasswordReset(Student $student): void
    {
        try {
            Mail::to($student->email)->send(new StudentResetPassword($student));
        } catch (TransportExceptionInterface $e) {

        }
    }
}
