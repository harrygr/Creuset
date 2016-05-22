<?php

class SearcherTest extends TestCase
{
    /** @test */
    public function it_searches_for_products()
    {
        $searcher = new App\Search\ProductSearcher;
        $product = factory('App\Product')->create()->toArray();

        SearchIndex::shouldReceive('getResults')->once()->andReturn([
            'hits' => [$product],
        ]);
        $results = $searcher->search('foo')->getResult();

        $this->assertEquals($product['name'], array_get($results->first(), 'name'));
    }
}
