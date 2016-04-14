<?php

namespace App\Http\Controllers;

use App\Page;

class PagesController extends Controller
{
    /**
     * Show a page as derived from a string of slugs.
     *
     * @return Response
     */
    public function show(Page $page)
    {
        return view('pages.single-page', compact('page'));
    }
}
