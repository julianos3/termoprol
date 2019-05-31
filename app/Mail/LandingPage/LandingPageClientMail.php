<?php

namespace AgenciaS3\Mail\LandingPage;

use Illuminate\Mail\Mailable;

class LandingPageClientMail extends Mailable
{
    public $contact;

    public $form;

    public function __construct(\AgenciaS3\Entities\LandingPageContact $contact, $form)
    {
        $this->contact = $contact;
        $this->form = $form;
    }

    public function build()
    {
        $subject = "Obrigado pelo cadastro";

        if (isset($this->form->subject)) {
            $subject = $this->form->subject;
        }

        if (isset($this->form->from)) {
            $email = $this->from(env('MAIL_FROM_ADDRESS'), isPost($this->form->from) ? $this->form->from : env('MAIL_FROM_NAME'));
        }

        if (isset($this->form->reply_to)) {
            $email = $this->replyTo($this->form->reply_to, $subject);
        }

        if (isset($this->form->file)) {
            $email = $this->attach(public_path('uploads/form/' . $this->form->file));
        }

        $email = $this->subject($subject)
            ->with([
                'data' => $this->contact,
                'textEmail' => $this->form->description
            ])
            ->view('vendor.emails.landing-page.client');


        return $email;
    }

}
