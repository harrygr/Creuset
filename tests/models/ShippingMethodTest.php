<?php

namespace Creuset;

use TestCase;

class ShippingMethodTest extends TestCase
{
    /** @test **/
    public function it_gets_the_price_of_a_shipping_method()
    {
        $shipping_method = factory(ShippingMethod::class)->create(['base_rate' => 5.60]);

        $this->assertEquals(5.6, $shipping_method->getPrice());
    }

}
