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
}
