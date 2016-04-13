<?php

namespace App\Http\Controllers;

use App\Page;

class PagesController extends Controller
{
    /**
     * Show a page as derived from a string of slugs.
     * 
     * @return [type] Response
     */
    public function show()
    {
        $slugs = collect(func_get_args());

        $page = $slugs->reduce(function($page, $slug) {

            abort_if(!$page, 404);
            return ($page->children()->published()->where('slug', $slug)->first());
            
        }, Page::whereSlug($slugs->shift())->published()->with('children')->first());

        abort_if(!$page, 404);

        return view('pages.single-page', compact('page'));
    }
}
