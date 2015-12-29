<?php

namespace Creuset\Listeners;

use Creuset\Events\OrderWasCompleted;
use Creuset\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReduceProductStock implements ShouldQueue
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
     * @param  OrderWasCompleted  $event
     * @return void
     */
    public function handle(OrderWasCompleted $event)
    {
        foreach ($event->order->items as $item) {
            $this->reduceStock($item->orderable, $item->quantity);
        }
    }

    private function reduceStock(Product $product, $quantity)
    {
        $product->stock_qty -= $quantity;
        // Fire an event here
        return $product->save();
    }
}
