<?php

namespace Integration;

use Creuset\User;
use TestCase;

class OrderTest extends TestCase
{
    use \UsesCart, \CreatesOrders;

    /** @test **/
    public function it_auto_creates_a_user_for_the_order_when_not_logged_in()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
        ->type('booboo@tempuser.com', 'email')
        ->fillAddress()
        ->check('shipping_same_as_billing')
        ->press('Proceed to Payment')
        ->seePageIs('checkout/pay');

        $this->seeInDatabase('orders', ['amount' => $product->getPrice(), 'status' => 'pending']);
        $this->seeInDatabase('users', ['email' => 'booboo@tempuser.com', 'auto_created' => true]);
        $this->seeInDatabase('addresses', ['city' => 'London']);
    }

    /** @test **/
    public function it_creates_an_order_from_a_logged_in_user()
    {
        $user = $this->loginWithUser([], 'customer');
        $product = $this->putProductInCart();
        $address = factory(\Creuset\Address::class)->create([
                                                            'user_id' => $user->id
                                                            ]);
        $current_stock = $product->stock_qty;

        $this->visit('checkout')
        ->select($address->id, 'billing_address_id')
        ->select($address->id, 'shipping_address_id')
        ->press('Proceed to Payment')
        ->seePageIs('checkout/pay');

        $this->seeInDatabase('orders', ['amount' => $product->getPrice(), 'status' => 'pending']);

        $order = \Creuset\Order::where('user_id', $user->id)->where('amount', $product->getPrice())->first();

        $this->assertEquals($address->id, $order->billing_address_id);
        $this->assertEquals($address->id, $order->shipping_address_id);

        $this->assertEquals($current_stock - 1, \Creuset\Product::find($product->id)->stock_qty);
    }

    /** @test **/
    public function it_creates_a_user_for_the_order_when_they_select_to_make_new_account()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
        ->type('booboo2@tempuser.com', 'email')
        ->fillAddress()
        ->check('shipping_same_as_billing')
        ->check('create_account')
        ->type('smoomoo', 'password')
        ->type('smoomoo', 'password_confirmation')
        ->press('Proceed to Payment')
        ->seePageIs('checkout/pay');

        $this->seeInDatabase('orders', ['amount' => $product->getPrice(), 'status' => 'pending']);
        $this->seeInDatabase('users', ['email' => 'booboo2@tempuser.com', 'auto_created' => false]);
        $this->seeInDatabase('addresses', ['city' => 'London']);
    }

    /** @test **/
    public function it_prompts_login_if_user_exists_but_is_signed_out()
    {
        $product = $this->putProductInCart();
        $user = factory(User::class)->create();

        $this->visit('checkout')
        ->type($user->email, 'email')
        ->press('Proceed to Payment')
        ->seePageIs(route('auth.login', ['email' => $user->email]))
        ->see('This email has an account here')
        ->type($user->email, 'email')
        ->type('password', 'password')
        ->press('Login')
        ->seePageIs('checkout');
    }

    /** @test **/
    public function it_validates_invalid_user_input()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
        ->type('tempuser.com', 'email')
        ->fillAddress()
        ->check('shipping_same_as_billing')
        ->check('create_account')
        ->press('Proceed to Payment')
        ->seePageIs('checkout');

    }

    /** @test **/
    public function it_views_an_order_summary()
    {
        $this->createOrder();
        $order = $this->order;
        $this->visit("account/orders/{$order->id}")
        ->see($order->amount);
    }

    /** @test **/
    public function it_does_not_allow_viewing_another_users_order_summary()
    {
        $this->createOrder();

        // Login with a different user
        $this->loginWithUser();

        $this->call('GET', "account/orders/{$this->order->id}");
        $this->assertResponseStatus(403);
    }

    protected function fillAddress($type = 'billing')
    {
        return $this
        ->type('Joe', "{$type}_address[first_name]")
        ->type('Bloggs', "{$type}_address[last_name]")
        ->type('10 Downing Street', "{$type}_address[line_1]")
        ->type('London', "{$type}_address[city]")
        ->type('England', "{$type}_address[country]")
        ->type('SW1A 2AA', "{$type}_address[postcode]")
        ->type('01234567891', "{$type}_address[phone]");
    }


}
