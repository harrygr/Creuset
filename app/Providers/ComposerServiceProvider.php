<?php

namespace Creuset\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('admin.users.form', function ($view) {
            
            $roles = \Creuset\Role::lists('display_name', 'id');

            $view->with(compact('roles'));

        });
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
