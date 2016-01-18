<?php

namespace Creuset;

use TestCase;

class OrderTest extends TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_updates_the_shipping_method_for_an_order()
    {
        $order_items = factory(OrderItem::class, 3)->create();

        $order = factory(Order::class)->create();

        $order->order_items()->saveMany($order_items);

        $this->assertFalse($order->hasShipping());

        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 500]);

        $order->setShipping($shipping_method->id);

        $this->assertTrue($order->fresh()->hasShipping());
        $this->assertEquals($order->shipping_method->id, $shipping_method->id);

        // Adding a new shipping method should replace the one currently there
        
        $shipping_method_2 = factory('Creuset\ShippingMethod')->create(['base_rate' => 600]);

        $order->setShipping($shipping_method_2->id);

        $this->seeInDatabase('order_items', ['orderable_type' => ShippingMethod::class, 'order_id' => $order->id, 'price_paid' => 6]);
        $this->notSeeInDatabase('order_items', ['orderable_type' => ShippingMethod::class, 'order_id' => $order->id, 'price_paid' => 5]);
        $this->assertEquals($order->shipping_method->id, $shipping_method_2->id);

    }

    /** @test **/
    public function it_refreshes_the_order_amount()
    {
        $order = factory(Order::class)->create();
        OrderItem::unguard();

        OrderItem::create([
            'order_id'          => $order->id,
            'description'       => 'A product',
            'price_paid'        => 89.20,
            'quantity'          => 2,
            'orderable_type'    => Product::class,
            'orderable_id'      => 1,
            ]);

        OrderItem::create([
            'order_id'          => $order->id,
            'description'       => 'A shipping method',
            'price_paid'        => 5,
            'quantity'          => 1,
            'orderable_type'    => ShippingMethod::class,
            'orderable_id'      => 1,
            ]);

        $order->refreshAmount();
        $this->assertEquals(183.4, $order->amount);

    }

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
        $order = new Order();

        // The billing and shipping addresses are unset so it should return false
        $this->assertFalse($order->shippingSameAsBilling());

        $order->billing_address_id = 1;
        $this->assertFalse($order->shippingSameAsBilling());

        $order->shipping_address_id = 1;
        $this->assertTrue($order->shippingSameAsBilling());
    }
}
