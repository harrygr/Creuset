<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartControllerTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    /** @test **/
    public function it_gets_the_cart_contents()
    {
        $product = factory(Product::class)->create();
        \Cart::add([
                  'id'    => $product->id,
                  'qty'   => 2,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);
        $this->get('api/cart');
    }

    /** @test **/
    public function it_adds_a_product_to_the_cart()
    {
        $product = factory(Product::class)->create();

        $this->post('api/cart', [
                    'product_id' => $product->id,
                    'quantity'   => 1,
                    ]);

        $this->assertEquals($product->getPrice(), Cart::total());
        $this->assertEquals(1, Cart::count());
    }

    /** @test **/
    public function it_adds_more_than_one_of_a_product_to_the_cart()
    {
        $product = factory(Product::class)->create();
        $this->post('api/cart', [
                    'product_id' => $product->id,
                    'quantity'   => 2,
                    ]);
        $this->assertEquals($product->getPrice() * 2, Cart::total());
        $this->assertEquals(2, Cart::count());
    }
}
