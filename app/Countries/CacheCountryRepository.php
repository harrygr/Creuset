<?php

namespace Creuset\Countries;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class CacheCountryRepository implements CountryRepository
{
    private $country_repository;

    public function __construct(CountryRepository $country_repository)
    {
        $this->country_repository = $country_repository;
    }

    /**
     * Get a list of all the countries
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'name')
    {
        return \Cache::remember("countries.list.$value.$key", config('cache.time'), function() use ($value, $key) {
            return $this->country_repository->lists($value, $key);
        });
    }
}
