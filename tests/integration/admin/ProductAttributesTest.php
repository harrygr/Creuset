<?php

namespace App\Http\Controllers\Admin;

class ProductAttributesTest extends \TestCase
{
    /** @test **/
    public function it_can_view_a_list_of_custom_attributes()
    {
        $attributes_1 = factory('App\ProductAttribute', 3)->create([
            'name' => 'Lampshade Size',
            ]);

        $attributes_2 = factory('App\ProductAttribute', 2)->create([
            'name' => 'Lampshade Colour',
            ]);

        $this->logInAsAdmin();

        $this->visit('admin/attributes')
             ->see('Lampshade Size')
             ->see('Lampshade Colour');
    }

    /** @test **/
    public function it_shows_the_page_for_creating_an_attribute()
    {
        $this->logInAsAdmin();

        $this->visit('admin/attributes/create')
             ->see('New Attribute');
    }

    /** @test **/
    public function it_shows_the_page_for_editing_an_attribute()
    {
        $this->logInAsAdmin();

        $attributes = factory('App\ProductAttribute', 3)->create([
            'name' => 'Lampshade Size',
            ]);

        $this->visit('admin/attributes/lampshade_size/edit')
             ->see('Edit Attribute');
    }

    /** @test **/
    public function it_deletes_all_terms_for_a_given_attribute()
    {
        $this->logInAsAdmin();

        $attributes = factory('App\ProductAttribute', 3)->create([
            'name' => 'Lampshade Size',
            ]);

        $this->call('DELETE', 'admin/attributes/lampshade_size');

        $this->assertRedirectedTo('admin/attributes');
        $this->notSeeInDatabase('product_attributes', ['slug' => 'lampshade_size']);
    }
}
