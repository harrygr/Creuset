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
}
