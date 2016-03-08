<?php

use App\Countries\CacheCountryRepository;
use App\Countries\CountryRepository;
use App\Countries\FileCountryRepository;
use App\Countries\RestCountriesCountryRepository;
use GuzzleHttp\Client;

class CountriesTest extends TestCase
{
    /** @test **/
    public function it_gets_a_list_of_countries_from_a_file()
    {
        $country_repository = new FileCountryRepository();

        $countries = $country_repository->lists();
        $this->assertContains('United Kingdom', $countries);
    }

    /** @test **/
    public function it_gets_a_list_of_countries_from_the_rest_api()
    {
        $json = file_get_contents(base_path('tests/resources/json/countries.json'));
        $client = Mockery::mock(Client::class);
        $country_response = Mockery::mock(['getStatusCode' => 200, 'getBody' => $json]);

        $client->shouldReceive('request')->once()->with('GET', 'https://restcountries.eu/rest/v1/all')->andReturn($country_response);

        $country_repository = new RestCountriesCountryRepository($client);

        $countries = $country_repository->lists();

        $this->assertContains('United Kingdom', $countries);
    }

    /** @test **/
    public function it_orders_with_popular_countries_first()
    {
        $country_repository = new FileCountryRepository();
        $country_repository->first_countries = ['GB', 'US'];

        $countries = $country_repository->lists();
        $this->assertEquals('United Kingdom', $countries->first());
    }

    /** @test **/
    public function it_takes_exception_to_non_existant_country_code()
    {
        $country_repository = new FileCountryRepository();
        $country_repository->first_countries = ['GB', 'US', 'XX'];

        $this->setExpectedException('\InvalidArgumentException');
        $countries = $country_repository->lists();
    }

    /** @test **/
    public function it_gets_a_country_name_from_a_code()
    {
        $country_repository = \App::make(CountryRepository::class);

        $this->assertEquals('United Kingdom', $country_repository->getByCode('GB'));
    }

    /** @test **/
    public function it_gets_a_list_of_countries_from_the_cache()
    {
        $mocked_country_repository = Mockery::mock(CountryRepository::class, ['lists' => [0 => 'United Kingdom']]);

        $cache_country_repository = new CacheCountryRepository($mocked_country_repository);

        $countries = $cache_country_repository->lists();
        $this->assertContains('United Kingdom', $countries);
    }
}
