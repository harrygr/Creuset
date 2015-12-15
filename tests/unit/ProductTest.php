<?php

namespace Creuset;

use Creuset\Product;
use Creuset\Repositories\Post\DbPostRepository;
use TestCase;

class ProductTest extends TestCase
{

    /** @test **/
    public function it_gets_the_usable_price_of_a_product()
    {
        $product = factory(Product::class)->create([
                                                   'price' => 20,
                                                   'sale_price' => 0,
                                                   ]);
        $this->assertEquals(20, $product->getPrice());

        $product = factory(Product::class)->create([
                                                   'price' => 20,
                                                   'sale_price' => 15,
                                                   ]);
        $this->assertEquals(15, $product->getPrice());

    }
}
