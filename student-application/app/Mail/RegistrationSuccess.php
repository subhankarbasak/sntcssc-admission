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
        // return $this->subject('Account Creation Successful - SNTCSSC Composite Course 2026')
        //     ->view('emails.registration_success')
        //     ->with([
        //         'student' => $this->student,
        //         'password' => $this->password,
        //     ]);

        $mail = $this->subject('Account Creation Successful - SNTCSSC Composite Course 2026')
                    ->view('emails.registration_success')
                    ->with([
                        'student' => $this->student,
                        'password' => $this->password,
                    ]);

        if (config('mail.reply_to_enabled', true)) {
            $mail->replyTo(config('mail.reply_to_address', 'iascoaching.sntcssc@gmail.com'), 'SNTCSSC Support');
        }

        if (config('mail.bcc_enabled', true)) {
            $mail->bcc(config('mail.bcc_address', 'iascoaching.sntcssc@gmail.com'));
        }

        return $mail;
    }
}