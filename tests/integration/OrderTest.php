<?php

namespace Integration;

use Creuset\User;

use TestCase;

class OrderTest extends TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_creates_an_order_from_a_logged_in_user()
    {
        $this->loginWithUser([], 'customer');
        $product = $this->putProductInCart();

        $this->visit('checkout')
             ->press('Place Order');

        $this->seeInDatabase('orders', ['total_paid' => $product->getPrice()]);
    }

    /** @test **/
    public function it_prompts_login_if_user_exists_but_is_signed_out()
    {
        $product = $this->putProductInCart();
        $user = factory(User::class)->create();

        $this->visit('checkout')
             ->type($user->email, 'email')
             ->press('Place Order')
             ->seePageIs(route('auth.login', ['email' => $user->email]))
             ->see('This email has an account here')
             ->type($user->email, 'email')
             ->type('password', 'password')
             ->press('Login')
             ->seePageIs('/checkout');
    }

}
