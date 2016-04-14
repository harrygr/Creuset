<?php

namespace Integration;

use App\Order;
use TestCase;

class OrdersTest extends TestCase
{
    use \CreatesOrders;

    /** @test */
    public function it_shows_a_list_of_orders_and_allows_order_completion()
    {
        $this->logInAsAdmin();

        $order = $this->createOrder(['status' => 'processing']);

        $this->visit('admin/orders')
             ->see("#{$order->id}")
             ->press('complete-order')
             ->see('Order Updated')
             ->see(Order::$statuses['completed']);
    }

    /** @test **/
    public function it_shows_a_single_order_summary()
    {
        $this->logInAsAdmin();

        $order = $this->createOrder(['status' => 'processing']);

        $this->visit("admin/orders/{$order->id}")
             ->see("#{$order->id}")
             ->select('completed', 'status')
             ->press('update-status')
             ->seePageIs("admin/orders/{$order->id}")
             ->see(Order::$statuses['completed']);
    }
}
