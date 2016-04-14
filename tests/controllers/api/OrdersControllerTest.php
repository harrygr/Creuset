<?php

namespace App\Http\Controllers\Api;

use App\Order;

class OrdersControllerTest extends \TestCase
{
    /** @test **/
    public function it_updates_an_order()
    {
        $order = factory(Order::class)->create(['status' => Order::PAID]);

        $this->logInAsAdmin();

        $response = $this->patch(route('api.orders.update', $order), ['status' => Order::COMPLETED]);

        $this->seeInDatabase('orders', ['id' => $order->id, 'status' => Order::COMPLETED]);
    }
}
