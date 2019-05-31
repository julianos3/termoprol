<?php

namespace AgenciaS3\Mail\LandingPage;

use Illuminate\Mail\Mailable;

class LandingPageMail extends Mailable
{
    public $contact;

    public function __construct(\AgenciaS3\Entities\LandingPageContact $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Novo cadastro recebido pelo site')
            ->with(['data' => $this->contact])
            ->view('vendor.emails.landing-page.admin');
    }

}
