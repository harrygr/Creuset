<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Term;

class TermsControllerTest extends \TestCase
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

    public function testICanSeeAListOfCategories()
    {
        $this->logInAsAdmin();

        $category = factory('Creuset\Term')->create([
          'taxonomy' => 'category',
          'term'     => 'homeparty',
          ]);

        $this->visit('/admin/categories')
        ->see('homeparty');
    }

    public function testICanDeleteATerm()
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
}
