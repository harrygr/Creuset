<?php

namespace Creuset\Listeners;

use Creuset\Events\OrderWasPaid;

class SendCustomerOrderEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //
    }
}
