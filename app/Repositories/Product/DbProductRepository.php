<?php

namespace Creuset\Repositories\Product;

use Creuset\Product;
use Creuset\Repositories\DbRepository;
use Creuset\Term;

class DbProductRepository extends DbRepository implements ProductRepository
{
    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public function create($attributes)
    {
        $product = $this->model->create($attributes);
        if (isset($attributes['terms'])) {
            $product->terms()->sync($attributes['terms']);
        }

        return $product;
    }

    public function inCategory(Term $product_category)
    {
        if ($product_category->slug == 'uncategorised') {
            return $this->model->has('product_categories', '=', 0)->paginate(config('shop.products_per_page'));
        }
        return $product_category->products()->paginate(config('shop.products_per_page'));
    }
}
