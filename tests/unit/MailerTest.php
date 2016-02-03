<?php


class MailerTest extends TestCase
{
    use MailTracking;

    /** @test **/
    public function it_sends_an_email_to_a_user()
    {
        $user = factory(\Creuset\User::class)->create();
        $mailer = app(\Creuset\Mailers\Mailer::class);

        $mailer->sendTo($user, 'This is a subject', 'emails.plain', ['body' => 'This is the email body']);

        $this->seeEmailTo($user->email)
             ->seeEmailSubject('This is a subject')
             ->seeEmailContains('This is the email body');
    }
}
