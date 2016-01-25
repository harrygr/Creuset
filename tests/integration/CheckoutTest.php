<?php

namespace Unit;

use TestCase;

class CheckoutTest extends TestCase
{
    /** @test **/
    public function it_redirects_if_no_order_is_in_session_or_cart_empty()
    {
        $this->visit('cart')
             ->see('nothing in your cart');

        $this->visit('checkout')
             ->see('nothing in your cart');

        $this->visit('checkout/shipping')
             ->see('without an order');

        $this->visit('checkout/pay')
             ->see('without an order');
    }
}
