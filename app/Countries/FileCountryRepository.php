<?php

namespace App\Countries;

use Illuminate\Support\Collection;

class FileCountryRepository implements CountryRepository
{
    use CollectableCountries;

    /**
     * The countries that should come first in the list.
     *
     * @var array
     */
    public $first_countries = ['GB', 'US'];

    /**
     * Get a collection of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $file_path = __DIR__.'/resources/countries.json';

        return new Collection(json_decode(file_get_contents($file_path), true));
    }
}
