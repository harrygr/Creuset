<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    /**
     * The table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_methods';

    /**
     * Validation rules for an address.
     *
     * @var array
     */
    public static $rules = [
    'description' => 'required',
    'base_rate'   => 'required|numeric',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['description', 'base_rate'];

    /**
     * Limit shipping methods to a certain country.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string                               $country_id
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCountry($query, $country_id)
    {
        $country_id = strtoupper($country_id);

        $query->whereHas('shipping_countries', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
        });
    }

    /**
     * Get the cost of a shipping method.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->base_rate;
    }

    /**
     * Store the base rate as an integer.
     *
     * @param float $rate
     */
    public function setBaseRateAttribute($rate)
    {
        $this->attributes['base_rate'] = (int) ($rate * 100);
    }

    /**
     * Convert the integer base rate to a float.
     *
     * @param int $rate
     *
     * @return float
     */
    public function getBaseRateAttribute($rate)
    {
        return $rate / 100;
    }

    /**
     * A shipping method has many shipping countries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function shipping_countries()
    {
        return $this->hasMany(ShippingCountry::class);
    }

    /**
     * Allow countries for a shipping method.
     *
     * @param array $countries An array of allowed country codes
     *
     * @return ShippingMethod
     */
    public function allowCountries(array $countries)
    {
        $this->shipping_countries()->delete();

        $shipping_countries = array_map(function ($country_id) {
            return new ShippingCountry(['country_id' => $country_id]);
        }, $countries);

        $this->shipping_countries()->saveMany($shipping_countries);

        return $this;
    }

    /**
     * Determines if a given country code is allowed for the shipping method.
     *
     * @param string $country_id The 2-letter country code
     *
     * @return bool
     */
    public function allowsCountry($country_id)
    {
        $country_id = strtoupper($country_id);

        return $this->shipping_countries->contains('country_id', $country_id);
    }
}
