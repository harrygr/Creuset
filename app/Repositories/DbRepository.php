<?php

namespace Creuset\Repositories;

abstract class DbRepository
{
    protected $model;

    /**
     * @param int   $id
     * @param array $with
     *
     * @return \Illuminate\Support\Collection|mixed|null|static
     */
    public function fetch($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * @param array $with
     *
     * @return mixed
     */
    public function all($with = [])
    {
        return $this->model->with($with)->latest()->get();
    }

    public function getBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
