<?php

trait MailTracking
{
    /**
     * Delivered emails.
     */
    protected $emails = [];

    /**
     * Register a listener for new emails.
     *
     * @before
     */
    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));

        $this->emails = [];
    }

    /**
     * Assert that at least one email was sent.
     */
    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails, 'No emails have been sent.'
        );

        return $this;
    }

    /**
     * Assert that no emails were sent.
     */
    protected function seeEmailWasNotSent()
    {
        $this->assertEmpty(
            $this->emails, 'Did not expect any emails to have been sent.'
        );

        return $this;
    }

    /**
     * Assert that the given number of emails were sent.
     *
     * @param int $count
     */
    protected function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);

        $this->assertCount(
            $count, $this->emails,
            "Expected $count emails to have been sent, but $emailsSent were."
        );

        return $this;
    }

    /**
     * Assert that the last email's body equals the given text.
     *
     * @param string        $body
     * @param Swift_Message $message
     */
    protected function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals(
            $body, $this->getEmail($message)->getBody(),
            'No email with the provided body was sent.'
        );

        return $this;
    }

    /**
     * Assert that the last email's body contains the given text.
     *
     * @param string        $excerpt
     * @param Swift_Message $message
     */
    protected function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains(
            $excerpt, $this->getEmail($message)->getBody(),
            'No email containing the provided body was found.'
        );

        return $this;
    }

    /**
     * Assert that the last email's subject matches the given string.
     *
     * @param string        $subject
     * @param Swift_Message $message
     */
    protected function seeEmailSubject($subject, Swift_Message $message = null)
    {
        $this->assertEquals(
            $subject, $this->getEmail($message)->getSubject(),
            "No email with a subject of $subject was found."
        );

        return $this;
    }

    /**
     * Assert that the last email was sent to the given recipient.
     *
     * @param string        $recipient
     * @param Swift_Message $message
     */
    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
        $recipients = is_null($message) ? $this->getAllRecipients() : (array) $this->getEmail($message)->getTo();

        $this->assertArrayHasKey(
            $recipient, $recipients,
            "No email was sent to $recipient."
        );

        return $this;
    }

    /**
     * Get all recipients who have been sent an email.
     *
     * @return array
     */
    public function getAllRecipients()
    {
        $recipients = array_map(function ($mail) {
            return $mail->getTo();
        }, $this->emails);

        $recips = [];
        foreach ($recipients as $recip_array) {
            $recips = array_merge($recips, $recip_array);
        }

        return $recips;
    }

    /**
     * Assert that the last email was delivered by the given address.
     *
     * @param string        $sender
     * @param Swift_Message $message
     */
    protected function seeEmailFrom($sender, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $sender, (array) $this->getEmail($message)->getFrom(),
            "No email was sent from $sender."
        );

        return $this;
    }

    /**
     * Store a new swift message.
     *
     * @param Swift_Message $email
     */
    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
    }

    /**
     * Retrieve the appropriate swift message.
     *
     * @param Swift_Message $message
     */
    protected function getEmail(Swift_Message $message = null)
    {
        $this->seeEmailWasSent();

        return $message ?: $this->lastEmail();
    }

    /**
     * Retrieve the mostly recently sent swift message.
     */
    protected function lastEmail()
    {
        return end($this->emails);
    }
}

class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $this->test->addEmail($event->getMessage());
    }
}
