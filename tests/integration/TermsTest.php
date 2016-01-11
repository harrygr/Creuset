<?php

namespace Integration;

use TestCase;

class TermsTest extends TestCase
{
    public function testICanSeeAListOfCategories()
    {
        $this->loginWithUser();

        $category = factory('Creuset\Term')->create([
      'taxonomy' => 'category',
      'term'     => 'homeparty',
      ]);

        $this->visit('/admin/categories')
         ->see('homeparty');
    }

    public function testICanDeleteATerm()
    {
        $this->withoutMiddleware();

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
