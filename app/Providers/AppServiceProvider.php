<?php

namespace App\Providers;

use App\Billing\GatewayInterface;
use App\Billing\StripeGateway;
use App\Page;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Page::moved(function ($page) {
            if ($page) {
                dispatch(new \App\Jobs\UpdatePagePath($page));
            }
        });

        Page::created(function ($page) {
            if ($page->isRoot()) {
                dispatch(new \App\Jobs\UpdatePagePath($page));
            }
        });

        Page::updated(function ($page) {
            if ($page->isDirty('slug') and $page->fresh()) {
                dispatch(new \App\Jobs\UpdatePagePath($page->fresh()));
            }
        });
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
            'App\Services\Registrar'
        );

        $this->app->singleton(GatewayInterface::class, StripeGateway::class);
    }
}
