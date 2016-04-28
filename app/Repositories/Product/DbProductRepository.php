<?php

namespace App\Repositories\Product;

use App\Product;
use App\ProductAttributeFilter;
use App\Repositories\DbRepository;
use App\Term;

class DbProductRepository extends DbRepository implements ProductRepository
{
    private $filter;

    /**
     * @param Product $product
     */
    public function __construct(Product $product, ProductAttributeFilter $filter)
    {
        $this->model = $product;

        $this->filter = $filter;
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
        return $product_category->products()->paginate(config('shop.products_per_page'));
    }

    /**
     * Build a query for all instances of a model.
     *
     *
     * @param array $with
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryAll($with = [])
    {
        return $this->model->filter($this->filter)
                           ->with($with)
                           ->latest();
    }
}
