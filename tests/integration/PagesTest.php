<?php

namespace Unit;

use App\Page;
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

    /** @test **/
    public function it_gets_the_permalink_for_a_nested_page()
    {
        $this->seedNestedPages();

        $page = Page::whereSlug('third')->first();

        $this->assertEquals('/first/second/third', $page->getPath());
        $this->assertEquals('/first/second', $page->getPath($excludeSelf = true));
    }

    /** @test **/
    public function it_gets_the_permalink_for_an_unnested_page()
    {
        $page = factory(Page::class)->create(['slug' => 'first']);
        $this->assertEquals('/first', $page->getPath());
        $this->assertEquals('/', $page->getPath(true));
    }

    /** @test **/
    public function it_shows_the_correct_page_from_nested_slugs()
    {
        $this->seedNestedPages();

        $page2 = Page::whereSlug('second')->first();
        $page3 = Page::whereSlug('third')->first();

        $this->visit('/first/second')
             ->see($page2->title)
             ->see($page2->content);

        $this->visit('/first/second/third')
             ->see($page3->title)
             ->see($page3->content);
    }

    /** @test **/
    public function it_doesnt_find_non_existant_pages()
    {
        $this->seedNestedPages();

        $response = $this->call('GET', '/first/second/no-page-here');
        $this->assertEquals(404, $response->status());

        $response = $this->call('GET', '/first/second/no-page-here/at-this-level-either');
        $this->assertEquals(404, $response->status());
    }

    /** @test **/
    public function it_doesnt_show_unpublished_pages()
    {
        $this->seedNestedPages();

        $page2 = Page::whereSlug('second')->first()->update(['status' => 'draft']);

        $response = $this->call('GET', '/first/second');

        $this->assertEquals(404, $response->status());
    }

    public function seedNestedPages()
    {
        $page1 = factory(Page::class)->create(['slug' => 'first']);
        $page2 = factory(Page::class)->create(['slug' => 'second']);
        $page3 = factory(Page::class)->create(['slug' => 'third']);

        $page2->makeChildOf($page1);
        $page3->makeChildOf($page2);
    }
}
