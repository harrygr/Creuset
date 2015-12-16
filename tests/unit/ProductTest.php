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

    /** @test **/
    public function it_gets_the_category_of_a_product()
    {
        $product = factory(Product::class)->create();

        $this->assertEquals('Uncategorised', $product->product_category->term);

        $product_category = factory(Term::class)->create([
          'taxonomy' => 'product_category'
          ]);

        $product->terms()->save($product_category);
        $product = Product::find($product->id);

        $this->assertEquals($product_category->term, $product->product_category->term);
    }

    /** @test **/
    public function it_gets_the_description_as_html()
    {
        $product = factory(Product::class)->create([
          'description' => '# Hello World!'
          ]);

        $this->assertContains('<h1>Hello World!</h1>', $product->getDescriptionHtml());
    }
}
