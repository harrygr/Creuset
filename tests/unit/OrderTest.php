<?php

namespace Unit;

use Creuset\Product;
use Creuset\Repositories\Post\DbPostRepository;
use TestCase;
use Creuset\User;
use Creuset\Address;
use Creuset\Order;

class OrderTest extends TestCase
{

    use \UsesCart;

    /** @test **/
    public function it_creates_an_order_from_a_customer_and_address()
    {
        $customer = factory(User::class)->create();
        $address = factory(Address::class)->create([
                           'user_id' => $customer->id
                           ]);

        $product = $this->putProductInCart();

        $order = Order::createFromCart($customer, $address->id);

        $this->assertEquals($order->billing_address_id, $address->id);
        $this->assertEquals($order->shipping_address_id, $address->id);
        
        $this->seeInDataBase('orders', ['user_id' => $customer->id]);
    }
}
