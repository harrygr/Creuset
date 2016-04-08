<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Post;
use App\Repositories\Post\PostRepository;
use App\Repositories\Term\TermRepository;
use Illuminate\Http\Response;

/**
 * Class PostsController.
 */
class PostsController extends Controller
{
    use \App\Traits\TrashesModels;

    /**
     * @var PostRepository
     */
    private $posts;

    /**
     * @var TermRepository
     */
    private $terms;

    /**
     * Create a new PostsController instance.
     *
     * @param PostRepository $posts PostRepository
     * @param TermRepository $terms TermRepository
     */
    public function __construct(PostRepository $posts, TermRepository $terms)
    {
        $this->posts = $posts;
        $this->terms = $terms;
    }

    /**
     * Show a listing of posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->posts->getPaginated(['categories', 'author']);

        return view('admin.posts.index')->with(compact('posts'));
    }

    /**
     * Show a page of trashed posts.
     *
     * @return Response
     */
    public function trash()
    {
        $posts = Post::onlyTrashed()->latest()->paginate(10);
        $title = 'Trash';

        return view('admin.posts.index')->with(compact('posts', 'title'));
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
     */
    public function store(CreatePostRequest $request)
    {
        $post = Post::create($request->all());
        $post->syncTerms($request->get('terms', []));

        return redirect()->route('admin.posts.edit', $post)
            ->with([
                'alert'       => 'Post saved',
                'alert-class' => 'success',
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post             $post
     * @param DbTermRepository $terms
     *
     * @return Response
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
        $post->update($request->all());
        $post->syncTerms($request->get('terms', []));

        return redirect()->route('admin.posts.edit', $post)
            ->with([
                'alert'       => 'Post Updated!',
                'alert-class' => 'success',
                ]);
    }

    /**
     * Show a page of attached images.
     *
     * @param Post $post
     *
     * @return Response
     */
    public function images(Post $post)
    {
        return view('admin.posts.images')->with(compact('post'));
    }

    /**
     * Restore the post from soft-deletion.
     *
     * @param Post $post
     *
     * @throws \Exception
     */
    public function restore(Post $post)
    {
        $post->restore();

        return redirect()->route('admin.posts.index')
            ->with([
                'alert'       => 'Post Restored',
                'alert-class' => 'success',
                ]);
    }
}
