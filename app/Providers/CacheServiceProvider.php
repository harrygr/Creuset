<?php

namespace App\Providers;

use App\Events\ModelWasChanged;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    private $cachable_models = [
        \App\Post::class,
        \App\Product::class,
        \App\Order::class,
        \App\ShippingMethod::class,
    ];

    public function boot()
    {
        foreach ($this->cachable_models as $cachable_model) {
            $cachable_model::saved(function ($model) {
                $this->fireEvent($model);
            });

            $cachable_model::deleted(function ($model) {
                $this->fireEvent($model);
            });

            // class::restored() only exists for soft-deleting models so we need to check first
            if (method_exists($cachable_model, 'restored')) {
                $cachable_model::restored(function ($model) {
                    $this->fireEvent($model);
                });
            }
        }
    }

    private function fireEvent($model)
    {
        event(new ModelWasChanged($model->getTable()));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
