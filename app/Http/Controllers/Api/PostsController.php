<?php

namespace Creuset\Http\Controllers\Api;

use Illuminate\Http\Request;

use Creuset\Post;
use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;

class PostsController extends Controller
{
    private $imageRepo;

	public function __construct()
	{
        $this->middleware('auth.basic', ['except' => ['show', 'images']]);
	}

    public function show(Request $request, $id = null)
    {
    	if (!$id) $id = $request->get('id');
    	var_dump($id);
    }

    public function images(Post $post)
    {
        return $post->images;
    }

}
