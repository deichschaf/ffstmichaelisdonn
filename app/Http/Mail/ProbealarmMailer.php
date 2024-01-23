<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProbealarmMailer extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $contact;

    public function __construct()
    {
    }

    public function build()
    {
        return $this->from('j-mh@j-mh.de')
            ->subject('Probealarm')
            ->text('email.probealarm_plain')
            ->with(['datum' => date('d.m.Y')]);
    }
}
