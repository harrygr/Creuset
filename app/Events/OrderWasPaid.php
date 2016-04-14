<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;

class OrderWasPaid extends Event
{
    public $order;
    public $payment_id;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Order  $order      The order that was paid for
     * @param string $payment_id The corresponding payment ID
     */
    public function __construct(Order $order, $payment_id)
    {
        $this->order = $order;
        $this->payment_id = $payment_id;
    }
}
