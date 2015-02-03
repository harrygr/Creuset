<?php namespace Creuset\Repositories;

abstract class DbRepository {
	protected $model;

	public function getAll($with = [])
	{
		return $this->model->with($with)->get();
	}

	public function getById($id)
	{
		return $this->model->find($id);
	}

	public function getBySlug($slug)
	{
		return $this->model->where('slug', $slug)->first();
	}
}

