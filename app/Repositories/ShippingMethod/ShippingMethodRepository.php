<?php

namespace App\Repositories\ShippingMethod;

interface ShippingMethodRepository
{
    /**
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    public function fetch($id, $with = []);

    public function all($with = []);

    /**
     * Get all shipping methods for a given country code.
     *
     * @param string $country_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forCountry($country_id);
}
