<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

// omdat dynamic properties niet werken vanaf php 8.2
class StudentProfileVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Studirect verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $verificationUrl = URL::signedRoute('students.verify', ['id' => $this->student->id]);

        return new Content(
            view: 'emails.student-verification',
            with: [
                'student' => $this->student,
                'verificationUrl' => $verificationUrl,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
