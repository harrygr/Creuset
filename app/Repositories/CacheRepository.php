<?php

namespace App\Repositories;

abstract class CacheRepository
{
    protected $repository;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The default tag for caching.
     *
     * @var string
     */
    protected $tag;

    /**
     * The cache string modifier in case of any request differences.
     *
     * @var string
     */
    protected $modifier = '';

    /**
     * Find an instance of the model by its ID.
     *
     * @param int   $id
     * @param array $with
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function fetch($id, $with = [])
    {
        $tags = array_merge([$this->tag], $with);

        return \Cache::tags($tags)->remember("{$this->tag}.{$id}", config('cache.time'), function () use ($id, $with) {
           return $this->repository->fetch($id, $with);
        });
    }

    /**
     * @param array $with Any relations to eager load
     *
     * @return mixed
     */
    public function getPaginated($with = [])
    {
        $page = \Request::get('page', 1);
        $tags = array_merge([$this->tag], $with);

        $cacheString = "{$this->tag}.paginated.page.{$page}{$this->modifier}";

        return \Cache::tags($tags)->remember($cacheString, config('cache.time'), function () use ($with) {
            return $this->repository->getPaginated($with);
        });
    }

    /**
     * Get all instances of the model.
     *
     * @param array $with Any relations to eager load
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($with = [])
    {
        $tags = array_merge([$this->tag], $with);

        return \Cache::tags($tags)->remember("{$this->tag}.all{$this->modifier}", config('cache.time'), function () use ($with) {
           return $this->repository->all($with);
        });
    }

    /**
     * Get a count of all models in the database.
     *
     * @return int
     */
    public function count()
    {
        return \Cache::tags([$this->tag])->remember("{$this->tag}.count{$this->modifier}", config('cache.time'), function () {
            return $this->repository->count();
        });
    }

    /**
     * Get an instance of a model by its slug.
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug($slug, $with = [])
    {
        $tags = array_merge([$this->tag], $with);

        return \Cache::tags($tags)->remember("{$this->tag}.slug.{$slug}", config('cache.time'), function () use ($slug, $with) {
            return $this->repository->getBySlug($slug, $with);
        });
    }
}
