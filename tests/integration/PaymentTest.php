<?php

namespace Integration;

use App\User;
use TestCase;

class PaymentTest extends TestCase
{
    use \CreatesOrders, \UsesCart, \MailTracking;

    /** @test **/
    public function it_completes_an_order_upon_payment()
    {
        $shop_admin = factory(User::class)->create();
        $this->createOrder(['status' => 'pending']);

        \Session::put('order', $this->order);

        $this->visit('checkout/pay');

        $token = $this->getToken();

        $response = $this->call('POST', route('payments.store'), [
            'order_id'     => $this->order->id,
            'stripe_token' => $token,
            '_token'       => csrf_token(),
            ]);

        $this->assertRedirectedTo('order-completed');

        $this->seeInDatabase('orders', ['id' => $this->order->id, 'status' => \App\Order::PAID]);
        $this->assertEquals(0, \Cart::total());
        $this->assertContains('ch_', $this->order->fresh()->payment_id);

        $this->seeEmailTo($this->customer->email, $this->emails[0]);

        $admin_users = User::shopAdmins()->get();
        $this->seeEmailTo($admin_users->first()->email, $this->emails[1]);
    }

    /** @test **/
    public function it_returns_to_the_pay_page_if_there_is_a_payment_error()
    {
        $this->createOrder(['status' => 'pending']);

        $this->order->setShipping(factory(\App\ShippingMethod::class)->create()->id);

        \Session::put('order', $this->order);

        $this->visit('checkout/pay');

        $token = $this->getToken(true);

        $response = $this->call('POST', route('payments.store'), [
            'order_id'     => $this->order->id,
            'stripe_token' => $token,
            '_token'       => csrf_token(),
            ]);

        $this->assertRedirectedTo('checkout/pay');
        $this->assertContains('declined', \Session::get('alert'));

        $this->dontSeeInDatabase('orders', ['id' => $this->order->id, 'status' => \App\Order::PAID]);
    }

    /**
     * Get a stripe token for creating a charge.
     *
     * @param bool $card_failure Whether the token should result in a payment error (e.g. card denied)
     *
     * @return string
     */
    protected function getToken($card_failure = false)
    {
        $address = factory('App\Address')->create();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $card_number = $card_failure ? '4000000000000002' : '4242424242424242';

        $token = \Stripe\Token::create([
            'card' => [
            'number'          => $card_number,
            'exp_month'       => 1,
            'exp_year'        => date('Y') + 1,
            'cvc'             => '314',
            'name'            => $address->full_name,
            'address_line1'   => $address->line_1,
            'address_line2'   => $address->line_2,
            'address_city'    => $address->city,
            'address_zip'     => $address->postcode,
            'address_country' => $address->country,
            ],
            ]);

        return $token->id;
    }
}
