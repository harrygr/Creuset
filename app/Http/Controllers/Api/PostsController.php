<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
    }

    public function show(Request $request, $id = null)
    {
        if (!$id) {
            $id = $request->get('id');
        }
        var_dump($id);
    }

    public function images(Post $post)
    {
        return $post->images;
    }
}
