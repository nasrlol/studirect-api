<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyAccountCreation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Company Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $registratieUrl = 'http://localhost:8000/placeholder';
        return new Content(
            view: 'emails.company-password',
                with: [
                'company' => $this->company,
                'verificationUrl' => $registratieUrl,
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
