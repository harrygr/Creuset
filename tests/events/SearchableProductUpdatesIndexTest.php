<?php

namespace Events;

use App\Product;
use TestCase;

class SearchableProductUpdatesIndexTest extends TestCase
{
    /** @test */
    public function it_updates_the_search_index_when_product_created()
    {
        \SearchIndex::shouldReceive('upsertToIndex')->once();
        $product = Product::create(factory(Product::class)->make()->toArray());
    }

    /** @test */
    public function it_updates_the_search_index_when_product_updated()
    {
        $product = factory(Product::class)->create();

        \SearchIndex::shouldReceive('upsertToIndex')->once();
        $product->update(['name' => 'Updated Product']);
    }

    /** @test */
    public function it_removes_the_product_from_the_search_index_when_deleted()
    {
        $product = factory(Product::class)->create();

        \SearchIndex::shouldReceive('removeFromIndex')->once();
        $product->delete();
    }
}
