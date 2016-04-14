<?php

namespace App\Countries;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class RestCountriesCountryRepository implements CountryRepository
{
    use CollectableCountries;

    private $http_client;
    private $base_url = 'https://restcountries.eu/rest/v1/';

    public function __construct(Client $http_client)
    {
        $this->http_client = $http_client;
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
