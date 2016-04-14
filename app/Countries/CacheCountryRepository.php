<?php

namespace App\Countries;

class CacheCountryRepository implements CountryRepository
{
    private $country_repository;

    public function __construct(CountryRepository $country_repository)
    {
        $this->country_repository = $country_repository;
    }

    /**
     * Get a list of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'alpha2Code')
    {
        return \Cache::remember("countries.list.$value.$key", config('cache.time'), function () use ($value, $key) {
            return $this->country_repository->lists($value, $key);
        });
    }

    /**
     * Get a country name by its Alpha2 code.
     *
     * @param string $code The alpha2 code
     *
     * @return string The country name
     */
    public function getByCode($code)
    {
        return \Cache::remember("country_by_code.$code", config('cache.time'), function () use ($code) {
            return $this->country_repository->getByCode($code);
        });
    }

    /**
     * Group the list of countries into subarrays organised by region.
     *
     * @return array
     */
    public function group()
    {
        return $this->country_repository->group();
    }
}
