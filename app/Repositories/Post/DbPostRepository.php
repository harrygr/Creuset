<?php namespace Creuset\Repositories\Post;

use \Creuset\Post;
use Creuset\Repositories\DbRepository;

class DbPostRepository extends DbRepository implements PostRepository {



	/**
	 * @param Post $post
	 */
	public function __construct(Post $post)
	{
		$this->model = $post;
	}

	/**
	 * @param $userId
	 * @return mixed
     */
	function getByUserId($userId)
	{
		return $this->model->where('user_id', $userId)->get();
	}

	/**
	 * @param array $with
	 * @return mixed
     */
	public function getPaginated($with = [])
	{
		return $this->model->with($with)->latest()->paginate(10);

	}

	/**
	 * @param array $attributes
	 * @return static
     */
	public function create($attributes)
	{
		$post = $this->model->create($attributes);
		if ( isset($attributes['terms']) )
			$post->terms()->sync($attributes['terms']);

		return $post;
	}

	/**
	 * @param Post $post
	 * @param array $attributes
	 * @return bool|int
     */
	public function update(Post $post, $attributes)
	{
		if ( isset($attributes['terms']) )
			$post->terms()->sync($attributes['terms']);

		return $post->update($attributes);
	}

	/**
	 * @param Post $post
	 * @return bool|null
	 * @throws \Exception
     */
	public function delete(Post $post)
	{
		return $post->delete();
	}
}