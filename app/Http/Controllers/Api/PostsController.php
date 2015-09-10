<?php

namespace Creuset\Http\Controllers\Api;

use Illuminate\Http\Request;

use Creuset\Post;
use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Repositories\Image\ImageRepository;

class PostsController extends Controller
{
    private $imageRepo;

	public function __construct(ImageRepository $imageRepo)
	{

        $this->imageRepo = $imageRepo;
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

    public function addImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg'
            ]);

        $post = $request->route('post');

        $image = $this->imageRepo->createFromForm($request->file('image'));
        $post->addImage($image);

        return $image;
    }
}
