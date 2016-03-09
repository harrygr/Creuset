<?php

namespace App;

use TestCase;

class ShippingMethodTest extends TestCase
{
    /** @test **/
    public function it_gets_the_price_of_a_shipping_method()
    {
        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 5.60]);

        $this->assertEquals(5.6, $shipping_method->getPrice());
    }

    /** @test **/
    public function it_assigns_available_countries_to_a_shipping_method()
    {
        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 5.60]);

        $shipping_method->allowCountries(['gb', 'fr', 'us']);

        $this->assertCount(3, $shipping_method->shipping_countries);

        $shipping_method->allowCountries(['de', 'ch']);

        $this->assertCount(2, $shipping_method->fresh()->shipping_countries);
    }

    /** @test **/
    public function it_determines_if_a_country_is_allowed_for_the_shipping_method()
    {
        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 5.60]);

        $shipping_method->allowCountries(['gb', 'fr', 'us']);

        $this->assertTrue($shipping_method->allowsCountry('us'));
        $this->assertFalse($shipping_method->allowsCountry('jp'));
    }

    /** @test **/
    public function it_gets_all_the_shipping_methods_for_a_given_country()
    {
        $shipping_methods = factory(ShippingMethod::class, 3)->create();

        $shipping_methods[0]->allowCountries(['gb', 'us']);
        $shipping_methods[1]->allowCountries(['jp']);
        $shipping_methods[2]->allowCountries(['gb', 'ch']);

        $this->assertCount(2, ShippingMethod::forCountry('gb')->get());
        $this->assertCount(1, ShippingMethod::forCountry('ch')->get());
        $this->assertCount(0, ShippingMethod::forCountry('de')->get());
    }
}
