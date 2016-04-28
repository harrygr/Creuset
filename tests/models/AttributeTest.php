<?php

namespace App;

use TestCase;

class AttributeTest extends TestCase
{
    /** @test **/
    public function it_gets_a_count_of_related_products()
    {
        $attribute = factory(ProductAttribute::class)->create(['name' => 'Size']);

        $products = factory(Product::class, 3)->create();

        $products->each(function ($product) use ($attribute) {
            $product->addProperty($attribute);
        });

        $this->assertEquals(3, $attribute->products->count());
    }
}
