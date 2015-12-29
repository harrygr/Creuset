<?php

namespace Events;

use Creuset\Events\OrderWasCompleted;
use Creuset\Product;
use Creuset\User;
use TestCase;

class OrderCompletedEventTest extends TestCase
{
    /** @test **/
    public function it_reduces_product_stock_when_order_completed()
    {
        $product_1 = factory('Creuset\Product')->create([
                                                        'stock_qty' => 4
                                                        ]);

        $product_2 = factory('Creuset\Product')->create([
                                                        'stock_qty' => 6
                                                        ]);
        $order = factory('Creuset\Order')->create();

        $order_item_1 = factory('Creuset\OrderItem')->create([
                                                        'description' => $product_1->name,
                                                        'quantity' => 2,
                                                        'price_paid' => $product_1->getPrice(),
                                                        'orderable_id' => $product_1->id,
                                                        'order_id' => $order->id
                                                        ]);

        $order_item_2 = factory('Creuset\OrderItem')->create([
                                                        'description' => $product_2->name,
                                                        'quantity' => 1,
                                                        'price_paid' => $product_2->getPrice(),
                                                        'orderable_id' => $product_2->id,
                                                        'order_id' => $order->id
                                                        ]);

        event(new OrderWasCompleted($order));

        $this->assertEquals(2, Product::find($product_1->id)->stock_qty);
        $this->assertEquals(5, Product::find($product_2->id)->stock_qty);

    }
}
