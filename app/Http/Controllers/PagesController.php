<?php

namespace App\Http\Controllers;

use App\Page;
use App\Http\Requests;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show(Page $page)
    {
        return view('pages.single-page', compact('page'));
    }
}
