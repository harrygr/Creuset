<?php

namespace App\Repositories\ShippingMethod;

use App\Repositories\DbRepository;
use App\ShippingMethod;

class DbShippingMethodRepository extends DbRepository implements ShippingMethodRepository
{
    /**
     * @param ShippingMethod $ShippingMethod
     */
    public function __construct(ShippingMethod $shipping_method)
    {
        $this->model = $shipping_method;
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
        return $this->model->forCountry($country_id)->get();
    }
}
