<?php

namespace Integration;

use App\ShippingMethod;
use TestCase;

class ShippingMethodsTest extends TestCase
{
    /** @test **/
    public function it_shows_a_list_of_shipping_methods()
    {
        $this->logInAsAdmin();

        $shipping_method = factory(ShippingMethod::class)->create();

        $this->visit('admin/shipping-methods')
             ->see($shipping_method->description);
    }

    /** @test **/
    public function it_creates_a_new_shipping_method()
    {
        $this->logInAsAdmin();

        $this->visit('admin/shipping-methods')
             ->type('Express Shipping', 'description')
             ->type('5.40', 'base_rate')
             // ->select('GB', 'shipping_countries[]')
             ->press('submit')
             ->seePageIs('admin/shipping-methods')
             ->see('Shipping Method Saved')
             ->see('Express Shipping');

        $shipping_method = ShippingMethod::where('description', 'Express Shipping')->first();

        //$this->assertTrue($shipping_method->allowsCountry('GB'));
    }

    /** @test **/
    public function it_can_delete_a_shipping_method()
    {
        $this->logInAsAdmin();

        $shipping_method = factory(ShippingMethod::class)->create();

        $this->call('DELETE', "admin/shipping-methods/{$shipping_method->id}");

        $this->assertRedirectedTo('admin/shipping-methods');

        $this->notSeeInDatabase('shipping_methods', ['description' => $shipping_method->description]);
    }

    /** @test */
    public function it_edits_a_shipping_method()
    {
        $this->logInAsAdmin();

        $shipping_method = factory(ShippingMethod::class)->create();

        $this->visit("admin/shipping-methods/{$shipping_method->id}/edit")
             ->type('Awesome Shipping', 'description')
             ->type('8.40', 'base_rate')
             //->select('GB', 'shipping_countries[]')
             ->press('submit')
             ->seePageIs('admin/shipping-methods')
             ->see('Shipping Method Updated')
             ->see('8.40');
    }
}
