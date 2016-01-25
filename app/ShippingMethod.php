<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    public static $rules = [
    'description' => 'required',
    'base_rate'   => 'required|numeric',
    ];

    public $fillable = ['description', 'base_rate'];

    /**
     * Limit shipping methods to a certain country
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  string $country_id
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCountry($query, $country_id)
    {
        $country_id = strtoupper($country_id);

        $query->whereHas('shipping_countries', function($q) use ($country_id) {
            $q->where('country_id', $country_id);
        });
    }

    /**
     * Get the cost of a shipping method
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->base_rate;
    }

    public function setBaseRateAttribute($rate)
    {
        $this->attributes['base_rate'] = (int) ($rate * 100);
    }

    public function getBaseRateAttribute($rate)
    {
        return ($rate / 100);
    }

    public function shipping_countries()
    {
        return $this->hasMany(ShippingCountry::class);
    }

    /**
     * Allow countries for a shipping method
     *
     * @param  array  $countries An array of allowed country codes
     * @return ShippingMethod
     */
    public function allowCountries(array $countries)
    {
        $this->shipping_countries()->delete();

        $shipping_countries = array_map(function($code) {
            return new ShippingCountry(['country_id' => $code]);
        }, $countries);

        $this->shipping_countries()->saveMany($shipping_countries);

        return $this;
    }

    /**
     * Determines if a given country code is allowed for the shipping method
     *
     * @param  string $country_id The 2-letter country code
     *
     * @return boolean
     */
    public function allowsCountry($country_id)
    {
        $country_id = strtoupper($country_id);
        return $this->shipping_countries->contains('country_id', $country_id);
    }
}
