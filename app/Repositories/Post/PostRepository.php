<?php namespace Creuset\Repositories\Post;

use Creuset\Post;

interface PostRepository {

	/**
	 * @param integer $id
	 * @return mixed
     */
	public function getById($id);

	/**
	 * @param array $with
	 * @return mixed
     */
	public function getPaginated($with);

	/**
	 * @param string $slug
	 * @return mixed
     */
	public function getBySlug($slug);

	/**
	 * @param array $attributes
	 * @return mixed
     */
	public function create($attributes);

	/**
	 * @param Post $post
	 * @param array $attributes
	 * @return mixed
     */
	public function update(Post $post, $attributes);

	/**
	 * @param Post $post
	 * @return mixed
     */
	public function delete(Post $post);
}