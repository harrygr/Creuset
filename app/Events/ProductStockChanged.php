<?php

namespace App\Events;

use App\Product;
use Illuminate\Queue\SerializesModels;

class ProductStockChanged extends Event
{
    use SerializesModels;

    public $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
