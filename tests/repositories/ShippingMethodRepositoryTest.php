<?php

namespace App\Repositories\ShippingMethod;

use App\ShippingMethod;
use TestCase;

class ShippingMethodRepositoryTest extends TestCase
{
    private $shipping_methods;

    public function setUp()
    {
        parent::setUp();

        $this->shipping_methods = \App::make(ShippingMethodRepository::class);
    }

    /** @test **/
    public function it_gets_all_shipping_methods()
    {
        $shipping_methods = factory(ShippingMethod::class, 3)->create();

        $this->assertCount(3, $this->shipping_methods->all());
    }

    /** @test **/
    public function it_gets_shipping_methods_for_a_given_country()
    {
        $shipping_methods = factory(ShippingMethod::class, 3)->create();

        $shipping_methods[0]->allowCountries(['GB']);

        $this->assertCount(1, $this->shipping_methods->forCountry('GB'));
    }
}
