<?php

namespace App\Countries;

interface CountryRepository
{
    /**
     * Get a list of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'alpha2Code');

    /**
     * Get a country name by its Alpha2 code.
     *
     * @param string $code The alpha2 code
     *
     * @return string The country name
     */
    public function getByCode($code);

    public function group();
}
