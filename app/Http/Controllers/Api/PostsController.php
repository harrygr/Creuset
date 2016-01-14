<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Post;
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
