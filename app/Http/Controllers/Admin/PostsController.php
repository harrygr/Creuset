<?php namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\PostRepository;
use Creuset\Post;
use Creuset\Http\Requests\UpdatePostRequest;

use Illuminate\Http\Request;

class PostsController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Post $post)
	{
		return view('admin.posts/edit')->with(compact('post'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Post $post, UpdatePostRequest $request)
	{
		$post->update($request->all());
		$alert = "Post Updated!";
		$alertClass = "alert-success";
		return view('admin.posts/edit')->with(compact(['post', 'alert', 'alertClass']));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
