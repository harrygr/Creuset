<?php

namespace App\Providers;

use App\Repositories\Order\CacheOrderRepository;
use App\Repositories\Order\DbOrderRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Post\CachePostRepository;
use App\Repositories\Post\DbPostRepository;
use App\Repositories\Post\PostRepository;
use App\Repositories\Product\CacheProductRepository;
use App\Repositories\Product\DbProductRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ShippingMethod\CacheShippingMethodRepository;
use App\Repositories\ShippingMethod\DbShippingMethodRepository;
use App\Repositories\ShippingMethod\ShippingMethodRepository;
use App\Repositories\Term\DbTermRepository;
use App\Repositories\Term\TermRepository;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
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
        $this->app->singleton(PostRepository::class, function () {
            return new CachePostRepository(
                $this->app->make(DbPostRepository::class)
            );
        });

        $this->app->singleton(TermRepository::class, function () {
            return $this->app->make(DbTermRepository::class);
        });

        $this->app->singleton(ProductRepository::class, function () {
            return new CacheProductRepository(
                $this->app->make(DbProductRepository::class)
            );
        });

        $this->app->singleton(OrderRepository::class, function () {
            return new CacheOrderRepository(
                $this->app->make(DbOrderRepository::class)
            );
        });

        $this->app->singleton(ShippingMethodRepository::class, function () {
            return new CacheShippingMethodRepository(
                $this->app->make(DbShippingMethodRepository::class)
            );
        });
    }
}
