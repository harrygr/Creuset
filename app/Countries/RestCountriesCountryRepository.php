<?php

namespace Creuset\Countries;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class RestCountriesCountryRepository implements CountryRepository
{
    private $http_client;
    private $base_url = 'https://restcountries.eu/rest/v1/';

    public function __construct(Client $http_client)
    {
        $this->http_client = $http_client;
    }

    /**
     * Get a list of all the countries.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($value = 'name', $key = 'alpha2Code')
    {
        return $this->all()->pluck($value, $key);
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
        return $this->getResponse('all');
    }

    private function getResponse($endpoint)
    {
        $response = $this->http_client->request('GET', $this->base_url.$endpoint);

        return new Collection(json_decode($response->getBody(), true));
    }
}
