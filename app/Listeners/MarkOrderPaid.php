<?php

namespace App\Listeners;

use App\Events\OrderWasPaid;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkOrderPaid implements ShouldQueue
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
        $event->order->update([
            'payment_id' => $event->payment_id,
            'status'     => \App\Order::PAID,
            ]);
    }
}
