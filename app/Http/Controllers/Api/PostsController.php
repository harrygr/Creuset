<?php

namespace Creuset\Http\Controllers\Api;

use Illuminate\Http\Request;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Repositories\Image\ImageRepository;

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

    private $imageRepo;

	public function __construct(PostRepository $postRepo, TermRepository $termRepo, ImageRepository $imageRepo)
	{
		$this->postRepo = $postRepo;
		$this->termRepo = $termRepo;
        $this->imageRepo = $imageRepo;
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

        $image = $this->imageRepo->createFromForm($request->file('image'));
        $post->addImage($image);

        return $image;
    }
}
