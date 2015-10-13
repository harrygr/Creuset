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

        $this->givePostCountsToPostIndex();
    }

    private function givePostCountsToPostIndex()
    {
        view()->composer('admin.posts.index', function($view) {
            $posts = $this->app->make(PostRepository::class);

            $view->with([
            'postCount' => $posts->count(),
            'trashedCount' => $posts->trashedCount(),
             ]);
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
