<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname, $lastname, $jobTitle;

    public function __construct($firstname, $lastname, $jobTitle)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->jobTitle = $jobTitle;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Status Lamaran - PT. Cubiconia Kanaya Pratama')
                    ->view('emails.rejected');
    }
}