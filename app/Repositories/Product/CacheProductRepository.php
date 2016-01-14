<?php

namespace Creuset\Repositories\Product;

use Creuset\Product;
use Creuset\Repositories\CacheRepository;
use Creuset\Term;

class CacheProductRepository extends CacheRepository implements ProductRepository
{
    /**
     * @param ProductRepository $repository
     * @param Product           $model
     */
    public function __construct(ProductRepository $repository, Product $model = null)
    {
        $this->repository = $repository;
        $this->model = $model ?: new Product();

        $this->tag = $this->model->getTable();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes)
    {
        return $this->repository->create($attributes);
    }

    public function inCategory(Term $product_category)
    {
        $tags = array_merge([$this->tag], ['terms']);

        return \Cache::tags($tags)->remember("{$this->tag}.inCategory.{$product_category->slug}", config('cache.time'), function () use ($product_category) {
            return $this->repository->inCategory($product_category);
        });
    }
}
