<?php

namespace Creuset;

use TestCase;

class OrderTest extends TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_creates_an_order_with_items()
    {
        $order_items = factory(OrderItem::class, 3)->create();

        $order = factory(Order::class)->create();

        $order->order_items()->saveMany($order_items);

        $this->assertCount(3, $order->order_items);
        $this->assertInstanceOf(User::class, $order->customer);
    }

    /** @test **/
    public function it_creates_an_order_from_a_customer_and_address()
    {
        $customer = factory(User::class)->create();
        $address = factory(Address::class)->create([
         'user_id' => $customer->id
         ]);

        $product = $this->putProductInCart();

        $order = Order::createFromCart($customer, ['billing_address_id' => $address->id, 'shipping_address_id' => $address->id]);

        $this->assertEquals($order->billing_address_id, $address->id);
        $this->assertEquals($order->shipping_address_id, $address->id);
        
        $this->seeInDataBase('orders', ['user_id' => $customer->id]);
    }
}
