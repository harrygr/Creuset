<?php

namespace Integration;

use App\Product;
use App\ProductAttribute;
use TestCase;

class AttributesTest extends TestCase
{
    /** @test **/
    public function it_filters_products_by_an_attribute()
    {
        $attribute = factory(ProductAttribute::class)->create(['name' => 'Size', 'property' => 'Huge', 'property_slug' => 'huge']);

        $product_1 = factory(Product::class)->create();
        $product_2 = factory(Product::class)->create();

        $product_1->addProperty($attribute);

        $this->visit('/shop?filter[size]=huge')
             ->see($product_1->name)
             ->dontSee($product_2->name);
    }
}
