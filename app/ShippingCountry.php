<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCountry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'shipping_countries';

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['country_id'];

    /**
     * Ensure the country ID is stored in uppercase.
     *
     * @param string $country_id
     */
    public function setCountryIdAttribute($country_id)
    {
        $this->attributes['country_id'] = strtoupper($country_id);
    }

    /**
     * Ensure the country ID is always uppercase.
     *
     * @param string $country_id
     *
     * @return string
     */
    public function getCountryIdAttribute($country_id)
    {
        return strtoupper($country_id);
    }
}
