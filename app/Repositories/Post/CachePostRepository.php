<?php namespace Creuset\Repositories\Post;


use Creuset\Post;

class CachePostRepository implements PostRepository {

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        return \Cache::remember("post_{$id}", env('CACHE_TIME'), function() use ($id)
        {
           return $this->repository->getById($id);
        });
    }

    /**
     * @param array $with
     * @return mixed
     */
    public function getPaginated($with)
    {
        return \Cache::remember('posts.paginated', env('CACHE_TIME'), function() use ($with)
        {
            return $this->repository->getPaginated($with);
        });
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->repository->getBySlug($slug);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes)
    {
        \Cache::forget("posts.paginated");
        return $this->repository->create($attributes);
    }

    /**
     * @param Post $post
     * @param array $attributes
     * @return mixed
     */
    public function update(Post $post, $attributes)
    {
        \Cache::forget("post_{$post->id}");
        \Cache::forget("posts.paginated");
        return $this->repository->update($post, $attributes);
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function delete(Post $post)
    {
        \Cache::forget("post_{$post->id}");
        \Cache::forget("posts.paginated");
        return $this->repository->delete($post);
    }
}