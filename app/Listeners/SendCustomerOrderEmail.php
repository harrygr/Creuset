<?php

namespace Creuset\Listeners;

use Creuset\Events\OrderWasPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  OrderWasPaid  $event
     * @return void
     */
    public function handle(OrderWasPaid $event)
    {
        //
    }
}
