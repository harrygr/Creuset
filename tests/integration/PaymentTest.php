<?php

namespace Integration;

use TestCase;

class PaymentTest extends TestCase
{
 use \CreatesOrders;

 /** @test **/
 public function it_completes_an_order_upon_payment()
 {
   $this->createOrder();

   \Session::put('order', $this->order);

   $this->visit('checkout/pay');

   $token = $this->getToken();

   $response = $this->call('POST', route('payments.store'), [
    'order_id'     => $this->order->id,
    'stripe_token' => $token,
    '_token'       => csrf_token(),
    ]);

   $this->assertRedirectedTo('order-completed');

   $this->seeInDatabase('orders', ['id' => $this->order->id, 'status' => 'paid']);
   $this->assertEquals(0, \Cart::total());
 }


   protected function getToken()
   {

    $address = factory('Creuset\Address')->create();

    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    $token = \Stripe\Token::create([
      "card" => [
        "number"          => "4242424242424242",
        "exp_month"       => 1,
        "exp_year"        => date('Y') + 1,
        "cvc"             => "314",
        'name'            => $address->full_name,
        'address_line1'   => $address->line_1,
        'address_line2'   => $address->line_2,
        'address_city'    => $address->city,
        'address_zip'     => $address->postcode,
        'address_country' => $address->country,
      ]
      ]);
    return $token->id;
  }
}
