<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname, $lastname, $jobTitle, $email, $password;

    public function __construct($firstname, $lastname, $jobTitle, $email, $password)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->jobTitle = $jobTitle;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Selamat, Anda Diterima di PT. Cubiconia Kanaya Pratama')
                    ->view('emails.accepted');
    }
}
