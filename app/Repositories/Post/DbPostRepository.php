<?php namespace Creuset\Repositories\Post;

use \Creuset\Post;

class DbPostRepository implements PostRepository {


	/**
	 * @param Post $post
	 */
	public function __construct(Post $post)
	{
		$this->post = $post;
	}

	/**
	 * @param $userId
	 * @return mixed
     */
	function getByUserId($userId)
	{
		return $this->post->where('user_id', $userId)->get();
	}

	/**
	 * @param array $with
	 * @return mixed
     */
	public function getAll($with = [])
	{
		return $this->post->with($with)->latest()->get();
	}

	/**
	 * @param array $with
	 * @return mixed
     */
	public function getPaginated($with = [])
	{
		return $this->post->with($with)->latest()->paginate(10);

	}

	/**
	 * @param int $id
	 * @return \Illuminate\Support\Collection|mixed|null|static
	 */
	public function getById($id)
	{
		return $this->post->find($id);
	}

	/**
	 * @param string $slug
	 * @return mixed
     */
	public function getBySlug($slug)
	{
		return $this->post->where('slug', $slug)->first();
	}

	/**
	 * @param array $attributes
	 * @return static
     */
	public function create($attributes)
	{
		return $this->post->create($attributes);
	}

	/**
	 * @param Post $post
	 * @param array $attributes
	 * @return bool|int
     */
	public function update(Post $post, $attributes)
	{
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