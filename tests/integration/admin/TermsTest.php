<?php

namespace App\Http\Controllers\Admin;

use App\Term;

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

        $category = factory('App\Term')->create([
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

        $category = factory('App\Term')->create([
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

        $category = factory('App\Term')->create([
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

        $category_1 = factory('App\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'Nasty Cat',
          ]);

        $category_2 = factory('App\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'Nice Cat',
          ]);

        $this->visit("admin/terms/{$category_1->id}/edit")
        ->type($category_2->term, 'term')
        ->press('submit')
        ->see('already been taken');

        $this->dontSeeInDatabase('terms', ['id' => $category_1, 'taxonomy' => 'category', 'term' => 'Nice Cat']);
    }
}
