<?php

namespace Unit;

use TestCase;

class PagesTest extends TestCase
{
    /** @test **/
    public function it_loads_a_page_by_slug()
    {
        $page = factory('App\Page')->create([
            'slug' => 'my-very-nice-page',
            ]);

        $this->visit('/my-very-nice-page')
             ->see($page->content);
    }
}
