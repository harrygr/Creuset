<?php

namespace Creuset\Http\Controllers\Api;

use Illuminate\Http\Request;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;

class PostsController extends Controller
{
	/**
	 * @var PostRepository
	 */
	private $postRepo;
	/**
	 * @var TermRepository
	 */
	private $termRepo;

	public function __construct(PostRepository $postRepo, TermRepository $termRepo)
	{
		$this->postRepo = $postRepo;
		$this->termRepo = $termRepo;
	}

    public function show(Request $request, $id = null)
    {
    	if (!$id) $id = $request->get('id');
    	var_dump($id);
    }

    public function addImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg'
            ]);

        $post = $request->route('post');

        $file = $request->file('image');

        $name = time() . $file->getClientOriginalName();

        $file->move('uploads/images', $name);

        $image = $post->images()->create([
            'path'              => "uploads/images/{$name}",
            'thumbnail_path'   => "uploads/images/{$name}"
            ]);


        return $image;
    }
}
