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
    public function it_deletes_old_items_before_adding_new_ones_from_the_cart()
    {
        // Given I have an order with an item in it already...
        $order = factory(Order::class)->create();

        $order_item = factory(OrderItem::class)->create(['order_id' => $order->id]);

        // And I have a product in the cart...
        $product = $this->putProductInCart();

        // If I sync the cart contents to the order...
        $order->syncWithCart();

        // The order items should correspond to the cart
        $this->assertEquals($product->getPrice(), $order->fresh()->amount);
        $this->seeInDatabase('order_items', ['orderable_id' => $product->id, 'order_id' => $order->id]);

        // And I shouldn't have the old item in the order anymore 
        $this->notSeeInDatabase('order_items', ['description' => $order_item->description]);
    }

    /** @test **/
    public function it_determines_if_the_billing_and_shipping_address_are_the_same()
    {
        $order = new Order;

        // The billing and shipping addresses are unset so it should return false
        $this->assertFalse($order->shippingSameAsBilling());

        $order->billing_address_id = 1;
        $this->assertFalse($order->shippingSameAsBilling());

        $order->shipping_address_id = 1;
        $this->assertTrue($order->shippingSameAsBilling());
    }
}
