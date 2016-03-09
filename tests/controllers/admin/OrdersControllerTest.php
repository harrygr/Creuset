<?php

namespace App\Http\Controllers\Admin;

use App\Order;

class OrdersControllerTest extends \TestCase
{
    use \CreatesOrders;

    public function setUp()
    {
        parent::setUp();
        $this->logInAsAdmin();
    }

    /** @test **/
    public function it_shows_a_single_order()
    {
        $order = $this->createOrder();

        $this->visit("admin/orders/{$order->id}")
             ->see("Order #{$order->id} Details");
    }

    /** @test **/
    public function it_completes_an_order()
    {
        $order = $this->createOrder(['status' => Order::PAID]);

        $this->visit('admin/orders')
             ->see(ucwords(Order::PAID))
             ->press('complete-order')
             ->seePageIs('admin/orders')
             ->see(ucwords(Order::COMPLETED));
    }

    /** @test **/
    public function it_shows_only_orders_of_a_certain_status()
    {
        $order_1 = $this->createOrder(['status' => Order::PAID]);
        $order_2 = $this->createOrder(['status' => Order::COMPLETED]);

        $this->visit('admin/orders/'.Order::PAID)
             ->see("#{$order_1->id}")
             ->dontSee("#{$order_2->id}");
    }
}
