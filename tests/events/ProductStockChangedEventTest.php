<?php

namespace Events;

use Creuset\Events\ProductStockChanged;
use Creuset\Product;
use Creuset\User;
use TestCase;

class ProductStockChangedEventTest extends TestCase
{
    /** @test **/
    public function it_alerts_to_a_product_being_out_of_stock()
    {
        $product = factory(Product::class)->create(['stock_qty' => 0]);

        \Mail::shouldReceive('send')->once();
        
        event(new ProductStockChanged($product));
    }

}
