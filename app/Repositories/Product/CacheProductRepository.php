<?php

namespace App\Repositories\Product;

use App\Product;
use App\Repositories\CacheRepository;
use App\Term;
use Illuminate\Http\Request;

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

        $this->setModifier();
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

    protected function setModifier()
    {
        $request = app(Request::class);

        if (count($params = $request->all())) {
            $this->modifier .= '.'.md5(json_encode($params));
        }
    }
}
