<?php

namespace App\Providers;

use App\Countries\CacheCountryRepository;
use App\Countries\CountryRepository;
use App\Countries\FileCountryRepository;
use Illuminate\Support\ServiceProvider;

class CountriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CountryRepository::class, function () {
            return new CacheCountryRepository($this->app->make(FileCountryRepository::class));
        });
    }
}
