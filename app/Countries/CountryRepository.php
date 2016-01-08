<?php

namespace Creuset\Countries;

interface CountryRepository
{
    /**
     * Get a list of all the countries
     * @return Array
     */
    public function lists($value = 'name', $key = 'name');
}