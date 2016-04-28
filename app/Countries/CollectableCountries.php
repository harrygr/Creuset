<?php

namespace App\Countries;

use Illuminate\Support\Collection;

/**
 * Common methods applicable to a collection of countries, regardless of their source.
 */
trait CollectableCountries
{
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
     * Get a list of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'alpha2Code')
    {
        $list = $this->all()->pluck($value, $key);

        if ($key == 'alpha2Code') {
            return $this->sortCountryList($list, $this->getFirstCountries());
        }

        return $list;
    }

    /**
     * Group the list of countries into subarrays organised by region.
     *
     * @return array
     */
    public function group()
    {
        $countries = $this->all()->groupBy('region');

        return $countries->map(function ($region) {
            return $region->pluck('name', 'alpha2Code');
        });
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

    /**
     * Get the country IDs that should be at the top of the list.
     *
     * @return array
     */
    protected function getFirstCountries()
    {
        return isset($this->first_countries) ? $this->first_countries : [];
    }
}
