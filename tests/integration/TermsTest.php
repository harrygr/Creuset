<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TermsTest extends TestCase
{
  use DatabaseTransactions;

  public function testICanSeeAListOfCategories()
  {
    $this->loginWithUser();

    $category = factory('Creuset\Term')->create([
      'taxonomy' => 'category',
      'term' => 'homeparty'
      ]);

    $this->visit('/admin/categories')
         ->see('homeparty');
  }

}
