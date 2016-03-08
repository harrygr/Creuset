<?php

namespace App;

use TestCase;

class OrderTest extends TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_adds_a_product_to_an_order()
    {
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $order->addProduct($product);

        $this->assertEquals(1, $order->product_items->count());
        $this->assertEquals($product->name, $order->product_items->first()->description);

        // If we add the same product again we expect just the quantity to be increased
        $order->addProduct($product, 2);
        $order = $order->fresh();
        $this->assertEquals(1, $order->product_items->count());
        $this->assertEquals(3, $order->product_items->first()->quantity);

        // And now we add a different product
        $product_2 = factory(Product::class)->create();
        $order->addProduct($product_2, 4);
        $order = $order->fresh();
        $this->assertEquals(2, $order->product_items->count());
        $this->assertEquals(4, $order->product_items->last()->quantity);
    }

    /** @test **/
    public function it_updates_the_shipping_method_for_an_order()
    {
        $order_items = factory(OrderItem::class, 3)->create();

        $order = factory(Order::class)->create();

        $order->order_items()->saveMany($order_items);

        $this->assertFalse($order->hasShipping());

        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 5]);

        $order->setShipping($shipping_method->id);

        $this->assertTrue($order->fresh()->hasShipping());
        $this->assertEquals($order->shipping_method->id, $shipping_method->id);

        // Adding a new shipping method should replace the one currently there

        $shipping_method_2 = factory('App\ShippingMethod')->create(['base_rate' => 6]);

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
    public function it_syncs_an_order_with_the_cart()
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

    /** @test **/
    public function it_gets_abandoned_orders()
    {
        $abandoned_orders = factory(Order::class, 2)->create([
            'status'     => Order::PENDING,
            'updated_at' => \Carbon\Carbon::parse('10 hours ago'),
            ]);

        $completed_order = factory(Order::class)->create([
            'status'     => Order::COMPLETED,
            'updated_at' => \Carbon\Carbon::parse('13 hours ago'),
            ]);

        $in_progress_order = factory(Order::class)->create([
            'status'     => Order::PENDING,
            'updated_at' => \Carbon\Carbon::parse('1 minute ago'),
            ]);

        $abandoned = Order::abandoned()->get();

        $this->assertCount(2, $abandoned);
    }
}
