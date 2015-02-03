<?php namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreatePostRequest;
use Creuset\Post;
use Creuset\Http\Requests\UpdatePostRequest;

use Creuset\Repositories\Post\PostRepository;
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
	 * @return Response
	 */
	public function create()
	{
		return view('admin.posts.create');
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
	 * @return Response
	 * @internal param int $id
	 */
	public function edit(Post $post)
	{
		return view('admin.posts.edit')->with(compact('post'));
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
