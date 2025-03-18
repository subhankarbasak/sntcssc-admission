<?php
// app/Mail/ApplicationStatusUpdated.php

namespace App\Mail;

use App\Models\Application;
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

        return $this->subject($subject)
            ->view('emails.application-status-updated')
            ->with([
                'studentName' => $this->application->studentProfile->first_name . ' ' . $this->application->studentProfile->last_name,
                'applicationId' => $this->application->application_number,
                'status' => $this->changedField === 'status' 
                    ? $this->application->status 
                    : $this->application->payment_status,
                'changedField' => $this->changedField
            ]);
    }
}