<?php

use App\Services\AttributeQueryBuilder;
use Illuminate\Http\Request;

class AttributeQueryBuilderTest extends TestCase
{
    /** @test */
    public function it_builds_a_simple_query_for_an_attribute()
    {
        $queryBuilder = new AttributeQueryBuilder($this->getFakeRequest());

        $queryString = $queryBuilder->addFilter('size', 'large')->getQueryString();

        $this->assertEquals('filter[size]=large', urldecode($queryString));
    }

    /** @test */
    public function it_builds_a_query_when_the_request_has_filters_already()
    {
        $queryBuilder = new AttributeQueryBuilder($this->getFakeRequest(['color' => 'blue']));

        $queryString = $queryBuilder->addFilter('size', 'large')->getQueryString();

        $this->assertEquals('filter[color]=blue&filter[size]=large', urldecode($queryString));
    }

    /** @test */
    public function it_build_a_query_for_when_the_filter_is_already_set()
    {
        $queryBuilder = new AttributeQueryBuilder($this->getFakeRequest(['color' => 'blue']));

        $queryString = $queryBuilder->addFilter('color', 'red')->getQueryString();

        $this->assertEquals('filter[color]=red', urldecode($queryString));
    }

    /** @test */
    public function it_builds_a_query_when_setting_the_filters()
    {
        $queryBuilder = new AttributeQueryBuilder($this->getFakeRequest(['color' => 'blue']));

        $queryString = $queryBuilder->addFilter('color', 'blue')
                                    ->setFilters(['color' => 'red'])
                                    ->getQueryString();

        $this->assertEquals('filter[color]=red', urldecode($queryString));
    }

    /** @test */
    public function it_removes_a_filter_if_already_on_the_query()
    {
        $queryBuilder = new AttributeQueryBuilder($this->getFakeRequest(['color' => 'blue', 'size' => 'large']));

        $queryString = $queryBuilder->setFilters(['size' => 'large'])->getQueryString();

        $this->assertEquals('filter[color]=blue', urldecode($queryString));
    }

    /** @test */
    public function it_determines_if_the_filter_is_set_in_the_request()
    {
        $queryBuilder = (new AttributeQueryBuilder($this->getFakeRequest(['color' => 'blue'])))->addFilter('size', 'large');

        $this->assertTrue($queryBuilder->hasCurrentFilter('color'));
        $this->assertTrue($queryBuilder->hasCurrentFilter('color', 'blue'));
        $this->assertFalse($queryBuilder->hasCurrentFilter('color', 'red'));

        $this->assertFalse($queryBuilder->hasCurrentFilter('size', 'large'));
        $this->assertFalse($queryBuilder->hasCurrentFilter('size', 'small'));

        $this->assertFalse($queryBuilder->hasCurrentFilter('length', 'short'));
        $this->assertFalse($queryBuilder->hasCurrentFilter('length'));
    }

    private function getFakeRequest($returnValue = null)
    {
        $fakeRequest = Mockery::mock(Request::class);
        $fakeRequest->shouldReceive('query')->with('filter')->andReturn($returnValue);

        return $fakeRequest;
    }
}
