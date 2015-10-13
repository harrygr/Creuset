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
     * @param array $with
     * @return mixed
     */
    public function getById($id, $with = [])
    {
        $withs = implode('-', $with);
        return \Cache::remember("post.{$id}.{$withs}", env('CACHE_TIME'), function() use ($id)
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
        $page = \Request::get('page', 0);

        return \Cache::tags('posts', 'posts.index')->remember("posts.paginated.page.{$page}", env('CACHE_TIME'), function() use ($with)
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
        \Cache::flush('posts.index');
        return $this->repository->create($attributes);
    }

    /**
     * @param Post $post
     * @param array $attributes
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
     * @return mixed
     */
    public function restore(Post $post)
    {
        \Cache::forget("post.{$post->id}");
        \Cache::flush('posts.index');
        return $this->repository->restore($post);
    }

    public function count()
    {
        return \Cache::tags('posts', 'posts.index')->remember("posts.count", env('CACHE_TIME'), function() {
            return $this->repository->count();
        });
    }

    public function trashedCount()
    {
        return \Cache::tags('posts', 'posts.index')->remember("posts.count.trashed", env('CACHE_TIME'), function() {
            return $this->repository->trashedCount();
        });
    }
}