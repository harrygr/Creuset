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
}
