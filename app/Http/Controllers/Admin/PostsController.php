<?php 

namespace Creuset\Http\Controllers\Admin;

use Creuset\Post;
use Creuset\Term;
use Creuset\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreatePostRequest;
use Creuset\Http\Requests\UpdatePostRequest;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;

/**
 * Class PostsController
 * @package Creuset\Http\Controllers\Admin
 */
class PostsController extends Controller {


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
		$this->middleware('auth');
		$this->postRepo = $postRepo;
		$this->termRepo = $termRepo;
	}


	/**
	 * @return Response
	 * @internal param PostRepository $postRepo
	 */
	public function index()
	{
		$posts = $this->postRepo->getPaginated(['categories', 'author']);

		return \View::make('admin.posts.index')->with(compact('posts'));
	}

	/**
	 * Show the form for creating a new post.
	 *
	 * @param DbTermRepository $termRepo
	 * @param Post $post
	 * @return Response
	 */
	public function create(TermRepository $termRepo, Post $post)
	{
		$selectedCategories = [];
		$categoryList = $termRepo->getCategoryList();
		$tagList = $termRepo->getTagList();
		$post->type = 'post';

		return view('admin.posts.create')->with(compact(
			'categoryList',
			'selectedCategories',
			'tagList',
			'post'
		));
	}

	/**
	 * Store a newly created post in storage.
	 *
	 * @param CreatePostRequest $request
	 * @return Response
	 * @internal param PostRepository $postRepo
	 * @internal param Post $post
	 */
	public function store(CreatePostRequest $request)
	{
		$post = $this->postRepo->create($request->all());

		return redirect()->route('admin.posts.edit', [$post->id])
			->with(['alert' => 'Post saved', 'alert-class' => 'success']);
	}

	

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Post $post
	 * @param DbTermRepository $termRepo
	 * @return Response
	 * @internal param int $id
	 */
	public function edit(Post $post, TermRepository $termRepo)
	{
		$post->load('categories', 'tags');

		$selectedCategories = $post->categories->lists('id')->toArray();
		
		$categoryList = $termRepo->getCategoryList($post);
		$tagList = $termRepo->getTagList();

		return view('admin.posts.edit')->with(compact(
			'post',
			'categoryList',
			'selectedCategories',
			'tagList'
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Post $post
	 * @param UpdatePostRequest $request
	 * @return Response
	 * @internal param int $id
	 */
	public function update(Post $post, UpdatePostRequest $request)
	{
		$attributes = $request->all();
		$attributes['terms'] = $this->termRepo->process($request->input('terms', []), 'tag');

		$this->postRepo->update($post, $attributes);
		$alert = "Post Updated!";

		return redirect()->route('admin.posts.edit', [$post])
			->with(compact('alert'))
			->with(['alert-class' => "success"]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Post $post
	 * @return Response
	 * @throws \Exception
	 * @internal param int $id
	 * @internal param Request $request
	 */
	public function destroy(Post $post)
	{
		$this->postRepo->delete($post);
		
		return redirect()->route('admin.posts.index')
			->with(['alert' => 'Post moved to trash', 'alert-class' => 'success']);
	}

}
