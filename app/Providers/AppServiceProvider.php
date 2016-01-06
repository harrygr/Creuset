<?php

namespace Creuset\Providers;

use Creuset\Billing\GatewayInterface;
use Creuset\Billing\StripeGateway;
use Creuset\Cart\Cart;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\HttpFoundation\Session\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'Creuset\Services\Registrar'
        );

        $this->app->singleton(GatewayInterface::class, StripeGateway::class);
    }
}
