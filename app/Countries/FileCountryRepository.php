<?php

namespace Creuset\Countries;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class FileCountryRepository implements CountryRepository
{
    /**
     * Get a list of all the countries
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'name')
    {
        return $this->all()->pluck($value, $key);
    }

    /**
     * Get a collection of all the countries
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $file_path = __DIR__ . '/resources/countries.json';

        return new Collection(json_decode(file_get_contents($file_path), true));
    }
}