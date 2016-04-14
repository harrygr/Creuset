<?php

use App\Page;

trait SeedsPages
{
    protected function seedNestedPages()
    {
        $pages = [
            factory(Page::class)->create(['slug' => 'first']),
            factory(Page::class)->create(['slug' => 'second']),
            factory(Page::class)->create(['slug' => 'third']),
        ];

        $pages[1]->makeChildOf($pages[0]);
        $pages[2]->makeChildOf($pages[1]);

        return $pages;
    }
}
