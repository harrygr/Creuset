<?php namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreatePostRequest;
use Creuset\Post;
use Creuset\Http\Requests\UpdatePostRequest;

use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\DbTermRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PostsController
 * @package Creuset\Http\Controllers\Admin
 */
class PostsController extends Controller {


	/**
	 * @var PostRepository
	 */
	private $postRepo;

	public function __construct(PostRepository $postRepo)
	{
		$this->middleware('auth');
		$this->postRepo = $postRepo;
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
	 * Show the form for creating a new resource.
	 *
	 * @param DbTermRepository $termRepo
	 * @return Response
	 */
	public function create(DbTermRepository $termRepo)
	{
		$selectedCategories = [];
		$categoryList = $termRepo->getCategoryList();
		$tagList = $termRepo->getTagList();

		return view('admin.posts.create')->with(compact(
			'categoryList',
			'selectedCategories',
			'tagList'
		));
	}

	/**
	 * Store a newly created resource in storage.
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Post $post
	 * @param DbTermRepository $termRepo
	 * @return Response
	 * @internal param int $id
	 */
	public function edit(Post $post, DbTermRepository $termRepo)
	{
		$post->load('categories', 'tags');

		$selectedCategories = $post->categories->lists('id');
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
		$this->postRepo->update($post, $request->all());
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
		$post->delete();
		return redirect()->route('admin.posts.index')
			->with(['alert' => 'Post moved to trash', 'alert-class' => 'success']);
	}

}
