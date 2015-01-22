<?php namespace Creuset\Repositories;

use \Creuset\Post;

class PostRepository extends DbRepository {

	protected $model;

	public function __construct(Post $model)
	{
		$this->model = $model;
	}

	function getByUserId($userId)
	{
		return $this->model->where('user_id', $userId)->get();
	}

	public function getAll($with = [])
	{
		return $this->model->with($with)->latest()->get();
	}
	public function getPaginated($with)
	{
		return $this->model->with($with)->latest()->paginate(10);

	}
}