<?php

namespace Creuset\Composers\Admin;

use Creuset\Repositories\Post\PostRepository;
use Illuminate\Contracts\View\View;

class PostViewComposer
{
    private $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function postCount(View $view)
    {
        $view->with([
            'postCount'    => $this->posts->count(),
            'trashedCount' => $this->posts->trashedCount(),
            ]);
    }
}
