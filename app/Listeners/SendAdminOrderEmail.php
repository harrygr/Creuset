<?php

namespace App\Listeners;

use App\Events\OrderWasPaid;
use App\Mailers\OrderMailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminOrderEmail implements ShouldQueue
{
    /**
     * @var OrderMailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param OrderWasPaid $event
     *
     * @return void
     */
    public function handle(OrderWasPaid $event)
    {
        $this->mailer->sendAdminOrderNotificationFor($event->order);
    }
}
