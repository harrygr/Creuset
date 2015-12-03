<?php

namespace Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class TermsTest extends TestCase
{
    use DatabaseTransactions;

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
}
