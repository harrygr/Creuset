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
    public function it_auto_creates_a_user_for_the_order_when_not_logged_in()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
             ->type('Temp User', 'name')
             ->type('booboo@tempuser.com', 'email')
             ->press('Place Order');

        $this->seeInDatabase('orders', ['total_paid' => $product->getPrice()]);
        $this->seeInDatabase('users', ['email' => 'booboo@tempuser.com', 'auto_created' => true]);
    }

    /** @test **/
    public function it_creates_a_user_for_the_order_when_they_select_to_make_new_account()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
             ->type('Temp User 2', 'name')
             ->type('booboo2@tempuser.com', 'email')
             ->check('create_account')
             ->type('smoomoo', 'password')
             ->type('smoomoo', 'password_confirmation')
             ->press('Place Order');

        $this->seeInDatabase('orders', ['total_paid' => $product->getPrice()]);
        $this->seeInDatabase('users', ['email' => 'booboo2@tempuser.com', 'auto_created' => false]);
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

    /** @test **/
    public function it_validates_invalid_user_input()
    {
        $product = $this->putProductInCart();

        $this->visit('checkout')
             ->type('Temp User 3', 'name')
             ->type('tempuser.com', 'email')
             ->check('create_account')
             ->press('Place Order')
             ->seePageIs('checkout');
             //->see()
    }
}
