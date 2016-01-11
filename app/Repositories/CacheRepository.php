<?php

namespace Creuset\Repositories;

abstract class CacheRepository
{

    protected $repository;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The default tag for caching
     * @var string
     */
    protected $tag;

    /**
     * Find an instance of the model by its ID
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
     * @param array $with
     *
     * @return mixed
     */
    public function getPaginated($with)
    {
        $page = \Request::get('page', 0);
        $tags = array_merge([$this->tag], $with);

        return \Cache::tags($tags)->remember("{$this->tag}.paginated.page.{$page}", config('cache.time'), function () use ($with) {
            return $this->repository->getPaginated($with);
        });
    }

    /**
     * Get all instances of the model
     * 
     * @param array $with
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($with = [])
    {
        $tags = array_merge([$this->tag], $with);

        return \Cache::tags($tags)->remember("{$this->tag}.all", config('cache.time'), function () use ($with) {
           return $this->model->with($with)->latest()->get();
        });        
    }

    /**
     * Get a count of all models in the database
     * @return integer
     */
    public function count()
    {
        return \Cache::tags([$this->tag])->remember("{$this->tag}.count", config('cache.time'), function () {
            return $this->repository->count();
        });
    }
}
