<?php

namespace App\Repositories\Post;

use App\Post;
use App\Repositories\DbRepository;

class DbPostRepository extends DbRepository implements PostRepository
{
    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * @param array $with
     *
     * @return mixed
     */
    public function getPaginated($with = [])
    {
        $query = $this->model->with($with)->latest();

        return $query->paginate(10);
    }

    public function trashedCount()
    {
        return $this->model->onlyTrashed()->count();
    }
}
