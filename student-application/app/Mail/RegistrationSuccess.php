<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $password;

    public function __construct($student, $password)
    {
        $this->student = $student;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Account Creation Successful - SNTCSSC Composite Course 2026')
            ->view('emails.registration_success')
            ->with([
                'student' => $this->student,
                'password' => $this->password,
            ]);
    }
}