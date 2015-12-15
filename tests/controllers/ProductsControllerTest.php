<?php

namespace Creuset\Http\Controllers;

use Creuset\Product;

class ProductsControllerTest extends \TestCase
{
    /** @test **/
    public function it_can_view_the_shop_page()
    {
        $products = factory(Product::class, 4)->create();
        $this->visit('shop')
             ->see($products->first()->name);
    }

    /** @test **/
    public function it_can_view_a_single_product()
    {
        $product = factory(Product::class)->create();

        $this->visit("shop/{$product->slug}")
             ->see($product->name)
             ->see($product->description);
    }

}