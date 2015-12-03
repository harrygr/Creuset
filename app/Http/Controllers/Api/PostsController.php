<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    private $imageRepo;

    public function __construct()
    {
        $this->middleware('auth.basic', ['except' => ['show', 'images']]);
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
