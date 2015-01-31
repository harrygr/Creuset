<?php namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreatePostRequest;
use Creuset\Repositories\PostRepository;
use Creuset\Post;
use Creuset\Http\Requests\UpdatePostRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PostsController
 * @package Creuset\Http\Controllers\Admin
 */
class PostsController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * @param PostRepository $postsRepo
	 * @return Response
     */
	public function index(PostRepository $postsRepo)
	{
		$posts = $postsRepo->getPaginated(['categories', 'author']);

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
	 * @param Post $post
	 * @param CreatePostRequest $request
	 * @return Response
	 */
	public function store(Post $post, CreatePostRequest $request)
	{
		$post = $post->create($request->all());
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
		$post->update($request->all());
		$alert = "Post Updated!";

		return redirect()->route('admin.posts.edit', [$post])
			->with(compact('alert'))
			->with(['alert-class' => "success"]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		dd($request);
	}

}
