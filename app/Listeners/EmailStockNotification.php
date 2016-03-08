<?php

namespace App\Listeners;

use App\Events\ProductStockChanged;
use App\Mailers\ProductMailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailStockNotification implements ShouldQueue
{
    private $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param ProductStockChanged $event
     *
     * @return void
     */
    public function handle(ProductStockChanged $event)
    {
        if ($event->product->stock_qty == 0) {
            $this->mailer->sendOutOfStockNotificationFor($event->product);
        } elseif ($event->product->stock_qty <= config('shop.low_stock_qty')) {
            $this->mailer->sendLowStockNotificationFor($event->product);
        }
    }
}
