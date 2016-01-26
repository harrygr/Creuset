<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class ShippingCountry extends Model
{
    public $timestamps = false;

    public $fillable = ['country_id'];

    /**
     * Ensure the country ID is stored in lowercase.
     *
     * @param string $country_id
     */
    public function setCountryIdAttribute($country_id)
    {
        $this->attributes['country_id'] = strtoupper($country_id);
    }

    public function getCountryIdAttribute($country_id)
    {
        return strtoupper($country_id);
    }
}
