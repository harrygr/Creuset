<?php

namespace Creuset\Repositories\Post;

use Creuset\Post;
use Creuset\Repositories\CacheRepository;

class CachePostRepository extends CacheRepository implements PostRepository
{
    /**
     * @param PostRepository $repository
     * @param Post $model
     */
    public function __construct(PostRepository $repository, Post $model = null)
    {
        $this->repository = $repository;
        $this->model = $model ?: new Post;

        $this->tag = $this->model->getTable();
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->repository->getBySlug($slug);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes)
    {
        \Cache::flush('posts.index');

        return $this->repository->create($attributes);
    }

    /**
     * @param Post  $post
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(Post $post, $attributes)
    {
        \Cache::forget("post.{$post->id}");
        \Cache::flush('posts.index');

        return $this->repository->update($post, $attributes);
    }

    /**
     * @param Post $post
     *
     * @return mixed
     */
    public function delete(Post $post)
    {
        \Cache::forget("post.{$post->id}");
        \Cache::flush('posts.index');

        return $this->repository->delete($post);
    }

    /**
     * @param Post $post
     *
     * @return mixed
     */
    public function restore(Post $post)
    {
        \Cache::forget("post.{$post->id}");
        \Cache::flush('posts.index');

        return $this->repository->restore($post);
    }

    public function trashedCount()
    {
        return \Cache::tags('posts', 'posts.index')->remember('posts.count.trashed', env('CACHE_TIME'), function () {
            return $this->repository->trashedCount();
        });
    }
}
