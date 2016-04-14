<?php

namespace App\Repositories\ShippingMethod;

use App\Repositories\CacheRepository;
use App\ShippingMethod;

class CacheShippingMethodRepository extends CacheRepository implements ShippingMethodRepository
{
    /**
     * @param ShippingMethodRepository $repository
     * @param ShippingMethod           $model
     */
    public function __construct(ShippingMethodRepository $repository, ShippingMethod $shipping_method = null)
    {
        $this->repository = $repository;
        $this->model = $shipping_method ?: new ShippingMethod();

        $this->tag = $this->model->getTable();
    }

    /**
     * Get all shipping methods for a given country code.
     *
     * @param string $country_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forCountry($country_id)
    {
        return \Cache::tags([$this->tag])->remember("shipping_methods.for_country.$country_id", config('cache.time'), function () use ($country_id) {
            return $this->repository->forCountry($country_id);
        });
    }
}
