<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject('Application Submission Confirmation - SNTCSSC 2026 Batch');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // $downloadUrl = route('application.download', $this->application->id);
        $downloadUrl = route('application.status', $this->application->application_number);

        return new Content(
            view: 'emails.application_submitted',
            with: [
                'studentName' => $this->application->profile->full_name ?? 'Student',
                'applicationNumber' => $this->application->application_number,
                'downloadUrl' => $downloadUrl,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}