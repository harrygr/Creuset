<?php

namespace Integration;

use TestCase;

class OrdersTest extends TestCase
{
    use \CreatesOrders;

    /** @test */
    public function it_shows_a_list_of_orders()
    {
        $this->logInAsAdmin();

        $order = $this->createOrder();

        $this->visit('admin/orders')
             ->see("#{$order->id}");
    }
}
