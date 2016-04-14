<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;

class OrderWasCreated extends Event
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
