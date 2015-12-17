<?php

namespace Creuset\Http\Controllers;

use Creuset\Product;

class CheckoutControllerTest extends \TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_shows_the_checkout_page()
    {
        $product = $this->putProductInCart();
        $this->visit('checkout')
             ->see($product->name);
    }

}