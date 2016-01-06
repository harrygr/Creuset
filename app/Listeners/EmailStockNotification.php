<?php

namespace Creuset\Listeners;

use Creuset\Events\ProductStockChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class EmailStockNotification
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
     * @param  ProductStockChanged  $event
     * @return void
     */
    public function handle(ProductStockChanged $event)
    {
        // if ($event->product->stock_qty == 0)
        // {
        //     $data = ['product' => $event->product];

        //     Mail::send('emails.products.out_of_stock', $data, function ($message) {
        //         $message->from('us@example.com', 'Laravel');

        //         $message->to('foo@example.com')->cc('bar@example.com');
        //     });
        // }
    }
}
