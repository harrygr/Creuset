<?php

namespace Integration;

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
             ->see('No order exists');

        $this->visit('checkout/pay')
             ->see('No order exists');
    }
}
