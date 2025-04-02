<?php
// app/Mail/ApplicationStatusUpdated.php

namespace App\Mail;

use App\Models\Application;
use App\Models\Unsubscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $changedField;

    public function __construct(Application $application, $changedField = 'status')
    {
        $this->application = $application;
        $this->changedField = $changedField;
    }

    public function build()
    {
        $subject = $this->changedField === 'status' 
                ? 'Application Status Update' 
                : 'Payment Status Update';

        $mail = $this->subject($subject)
            ->view('emails.application-status-updated')
            ->with([
                'studentName' => $this->application->studentProfile 
                    ? $this->application->studentProfile->first_name . ' ' . $this->application->studentProfile->last_name 
                    : 'Student',
                'applicationId' => $this->application->application_number ?? 'N/A',
                'status' => $this->changedField === 'status' 
                    ? $this->application->status 
                    : $this->application->payment_status,
                'changedField' => $this->changedField,
            ]);

        if (config('mail.reply_to_enabled', true)) {
            $mail->replyTo(config('mail.reply_to_address', 'iascoaching.sntcssc@gmail.com'), 'SNTCSSC Support');
        }

        if (config('mail.bcc_enabled', true)) {
            $mail->bcc(config('mail.bcc_address', 'iascoaching.sntcssc@gmail.com'));
        }

        return $mail;

        // $subject = $this->changedField === 'status' 
        //     ? 'Application Status Update'
        //     : 'Payment Status Update';

        // return $this->subject($subject)
        //     ->view('emails.application-status-updated')
        //     ->with([
        //         'studentName' => $this->application->studentProfile->first_name . ' ' . $this->application->studentProfile->last_name,
        //         'applicationId' => $this->application->application_number,
        //         'status' => $this->changedField === 'status' 
        //             ? $this->application->status 
        //             : $this->application->payment_status,
        //         'changedField' => $this->changedField
        //     ]);
    }
}