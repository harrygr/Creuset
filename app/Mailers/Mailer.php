<?php

namespace App\Mailers;

class Mailer
{
    private $mail;

    /**
     * Create a new Mailer instance.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mail
     */
    public function __construct(\Illuminate\Contracts\Mail\Mailer $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Send an email to a user.
     *
     * @param User   $user    The user to recieve the email
     * @param string $subject
     * @param string $view
     * @param array  $data
     *
     * @return void
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        $this->mail->queue($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }
}
