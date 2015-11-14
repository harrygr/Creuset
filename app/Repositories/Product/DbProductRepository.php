<?php 

namespace Creuset\Repositories\Product;

use Creuset\Product;
use Creuset\Repositories\DbRepository;

class DbProductRepository  extends DbRepository implements ProductRepository {

	/**
	 * @param Product $product
	 */
	public function __construct(Product $product)
	{
		$this->model = $product;
	}

	/**
	 * @param array $attributes
	 * @return static
     */
	public function create($attributes)
	{
		$product = $this->model->create($attributes);
		if ( isset($attributes['terms']) )
			$product->terms()->sync($attributes['terms']);

		return $product;
	}

}