<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Term;

class TermsTest extends \TestCase
{
    /** @test **/
    public function it_lists_the_terms_by_taxonomy()
    {
        $this->logInAsAdmin();
        $category = factory(Term::class)->create(['taxonomy' => 'category']);
        $tag = factory(Term::class)->create(['taxonomy' => 'tag']);

        $this->visit('/admin/terms/categories')
        ->see('Categories')
        ->see($category->term)
        ->dontSee($tag->term);
    }

    /** @test **/
    public function it_lists_categories()
    {
        $this->logInAsAdmin();

        $category = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'homeparty',
          ]);

        $this->visit('/admin/categories')
        ->see('homeparty');
    }

    /** @test **/
    public function it_can_delete_a_term()
    {
        $this->logInAsAdmin();

        $category = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'nasty cat',
          ]);

        $this->seeInDatabase('terms', ['term' => 'nasty cat', 'taxonomy' => 'category']);

        $response = $this->action('DELETE', 'Admin\TermsController@destroy', ['term' => $category]);

        $this->assertRedirectedTo('/admin/categories');
        $this->notSeeInDatabase('terms', ['term' => 'nasty cat', 'taxonomy' => 'category']);
    }

    /** @test **/
    public function it_can_edit_a_term()
    {
        $this->logInAsAdmin();

        $category = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'Nasty Cat',
          ]);

        $this->visit("admin/terms/{$category->id}/edit")
        ->type('Nice Cat', 'term')
        ->press('submit')
        ->see('Category updated');

        $this->seeInDatabase('terms', ['taxonomy' => 'category', 'term'     => 'Nice Cat']);
    }

    /** @test **/
    public function it_cannot_save_a_term_that_already_exists()
    {
        $this->logInAsAdmin();

        $category_1 = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'Nasty Cat',
          ]);

        $category_2 = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'Nice Cat',
          ]);

        $this->visit("admin/terms/{$category_1->id}/edit")
        ->type($category_2->term, 'term')
        ->press('submit')
        ->see('already been taken');

        $this->dontSeeInDatabase('terms', ['id' => $category_1, 'taxonomy' => 'category', 'term' => 'Nice Cat']);
    }

    /** CUSTOM ATTRIBUTES **/

    /** @test **/
    public function it_can_view_a_list_of_custom_attributes()
    {
        $attributes_1 = factory('Creuset\Term', 3)->create([
            'taxonomy' => 'lampshade_size',
            ]);

        $attributes_2 = factory('Creuset\Term', 2)->create([
            'taxonomy' => 'lampshade_colour',
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

        $attributes_1 = factory('Creuset\Term', 3)->create([
            'taxonomy' => 'lampshade_size',
            ]);

        $this->visit('admin/attributes/lampshade_size/edit')
             ->see('Edit Lampshade Size');
    }

}
