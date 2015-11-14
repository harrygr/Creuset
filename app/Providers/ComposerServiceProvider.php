<?php

namespace Creuset\Providers;

use Creuset\Repositories\Post\PostRepository;
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

        view()->composer(
            ['admin.products.images', 'admin.products.edit'],
            \Creuset\Composers\NavViewComposer::class . '@productLinks'
        );

        view()->composer('admin.posts.index', \Creuset\Composers\Admin\PostViewComposer::class . '@postCount');
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
