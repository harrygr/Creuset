<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show(Post $page)
    {
        return view('pages.single-page', compact('page'));
    }
}
