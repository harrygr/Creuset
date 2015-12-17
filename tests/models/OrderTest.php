<?php

namespace Creuset;

use TestCase;

class OrderTest extends TestCase
{

    /** @test **/
    public function it_creates_an_order_with_items()
    {
        $order_items = factory(OrderItem::class, 3)->create();

        $order = factory(Order::class)->create();

        $order->order_items()->saveMany($order_items);

        $this->assertCount(3, $order->order_items);
        $this->assertInstanceOf(User::class, $order->customer);
    }
}
