<?php

namespace Integration;

use Creuset\Product;
use TestCase;

class ShopTest extends TestCase
{

    /** @test **/
    public function it_can_add_a_product_to_the_cart()
    {
        $product = factory(Product::class)->create();

        $this->visit('/shop')
             ->see($product->name)
             ->click($product->name)
             ->seePageIs("/shop/{$product->slug}")
             ->press('Add To Cart');

        $cart_row = \Cart::content()->first();
        $this->assertEquals($product->name, $cart_row->name);
        $this->assertEquals($product->getPrice(), \Cart::total());
    }

}
