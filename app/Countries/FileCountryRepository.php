<?php

namespace App\Countries;

use Illuminate\Support\Collection;

class FileCountryRepository implements CountryRepository
{
    /**
     * The countries that should come first in the list.
     *
     * @var array
     */
    public $first_countries = ['GB', 'US'];

    /**
     * Get a list of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'alpha2Code')
    {
        $list = $this->all()->pluck($value, $key);

        if ($key == 'alpha2Code') {
            return $this->sortCountryList($list, $this->first_countries);
        }

        return $list;
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
        $countries = $this->lists();

        return $countries->get($code);
    }

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

    /**
     * Sort a list of countries, putting the first countries at the top.
     *
     * @param Collection $list
     * @param array      $top_keys The keys that should appear at the top of the list
     *
     * @return Collection
     */
    protected function sortCountryList(Collection $list, array $top_keys = [])
    {
        $list = $list->sort();

        $first_countries = new Collection();
        foreach ($top_keys as $code) {
            if (!$list->has($code)) {
                throw new \InvalidArgumentException("The country code '$code' does not exist");
            }

            $first_countries = $first_countries->merge([$code => $list->pull($code)]);
        }

        return $first_countries->merge($list);
    }
}
