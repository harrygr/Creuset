<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreatePostRequest;
use Creuset\Http\Requests\UpdatePostRequest;
use Creuset\Post;
use Creuset\Repositories\Post\PostRepository;
use Creuset\Repositories\Term\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PostsController.
 */
class PostsController extends Controller
{
    use \Creuset\Traits\TrashesModels;

    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var TermRepository
     */
    private $terms;

    public function __construct(PostRepository $posts, TermRepository $terms)
    {
        $this->posts = $posts;
        $this->terms = $terms;
    }

    /**
     * @return Response
     *
     * @internal param PostRepository $posts
     */
    public function index()
    {
        $posts = $this->posts->getPaginated(['categories', 'author']);

        return \View::make('admin.posts.index')->with(compact('posts'));
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->latest()->paginate(10);
        $title = 'Trash';

        return \View::make('admin.posts.index')->with(compact('posts', 'title'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @param DbTermRepository $terms
     * @param Post             $post
     *
     * @return Response
     */
    public function create(TermRepository $terms, Post $post)
    {
        $selectedCategories = [];
        $categoryList = $terms->getCategoryList();
        $tagList = $terms->getTagList();
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
     *
     * @return Response
     *
     * @internal param PostRepository $posts
     * @internal param Post $post
     */
    public function store(CreatePostRequest $request)
    {
        $post = $this->posts->create($request->all());

        return redirect()->route('admin.posts.edit', [$post->id])
            ->with(['alert' => 'Post saved', 'alert-class' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post             $post
     * @param DbTermRepository $terms
     *
     * @return Response
     *
     * @internal param int $id
     */
    public function edit(Post $post, TermRepository $terms)
    {
        $post->load('categories', 'tags');

        $selectedCategories = $post->categories->lists('id')->toArray();

        $categoryList = $terms->getCategoryList($post);
        $tagList = $terms->getTagList();

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
     * @param Post              $post
     * @param UpdatePostRequest $request
     *
     * @return Response
     *
     * @internal param int $id
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        $attributes = $request->all();
        $attributes['terms'] = $this->terms->process($request->input('terms', []), 'tag');

        $this->posts->update($post, $attributes);
        $alert = 'Post Updated!';

        return redirect()->route('admin.posts.edit', [$post])
            ->with(compact('alert'))
            ->with(['alert-class' => 'success']);
    }

    public function images(Post $post)
    {
        return view('admin.posts.images')->with(compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     *
     * @throws \Exception
     *
     * @return Response
     *
     * @internal param int $id
     * @internal param Request $request
     */
    // public function destroy(Post $post)
    // {
    // 	$alert = 'Post moved to trash';
    //
    // 	if ($post->trashed()) {
    // 		$alert = "Post permanently deleted";
    // 	}
    //
    // 	$this->posts->delete($post);
    //
    // 	return redirect()->route('admin.posts.index')
    // 		->with(['alert' => $alert, 'alert-class' => 'success']);
    // }

    public function restore(Post $post)
    {
        $this->posts->restore($post);

        return redirect()->route('admin.posts.index')
            ->with(['alert' => 'Post Restored', 'alert-class' => 'success']);
    }
}
