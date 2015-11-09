<?php 

namespace Creuset\Repositories\Product;

use Creuset\Product;

interface ProductRepository {

	/**
	 * @param integer $id
	 * @param array $with
	 * @return mixed
	 */
	public function fetch($id, $with = []);

	public function all($with = []);

	/**
	 * @param array $attributes
	 * @return mixed
     */
	public function create($attributes);

}