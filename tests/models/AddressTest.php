<?php

namespace App;

use TestCase;

class AddressTest extends TestCase
{
    /** @test **/
    public function it_gets_the_country_for_an_address()
    {
        $address = factory(Address::class)->make(['country' => 'GB']);
        $country_repository = \Mockery::mock(\App\Countries\CountryRepository::class);
        $country_repository->shouldReceive('getByCode')->once()->with('GB')->andReturn('United Kingdom');

        \App::shouldReceive('make')->once()->andReturn($country_repository);

        $this->assertEquals('United Kingdom', $address->country_name);
    }

    /** @test **/
    public function it_gets_the_country_code_for_an_address()
    {
        $address = factory(Address::class)->make(['country' => 'GB']);

        $this->assertEquals('GB', $address->country);
    }
}
