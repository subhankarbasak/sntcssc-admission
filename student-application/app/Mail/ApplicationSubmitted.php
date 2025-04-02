<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;
use App\Models\Unsubscribe;

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
        // Check if the user has unsubscribed
        if (Unsubscribe::where('email', $this->application->studentProfile?->email)->exists()) {
            return $this; // Skip sending the email
        }

        $mail = $this->subject('Application Submission Confirmation - SNTCSSC 2026 Batch');
        
        if (config('mail.reply_to_enabled', true)) {
            $mail->replyTo(config('mail.reply_to_address', 'iascoaching.sntcssc@gmail.com'), 'SNTCSSC Support');
        }

        if (config('mail.bcc_enabled', true)) {
            $mail->bcc(config('mail.bcc_address', 'iascoaching.sntcssc@gmail.com'));
        }

        return $mail;

        // return $this->subject('Application Submission Confirmation - SNTCSSC 2026 Batch');
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