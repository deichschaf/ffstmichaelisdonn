<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contactform extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Kontaktanfrage')
            ->view('email.contact_html')
            ->with(['contact' => $this->contact]);
    }
}
