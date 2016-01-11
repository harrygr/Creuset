<?php

namespace Creuset\Providers;

use Creuset\Countries\CountryRepository;
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
        $this->shareRoles();

        $this->shareNavLinks();

        $this->sharePostData();
    }

    /**
     * Share a list of roles with the views that require it.
     *
     * @return void
     */
    private function shareRoles()
    {
        view()->composer('admin.users.form', function ($view) {

            $roles = \Creuset\Role::lists('display_name', 'id');

            $view->with(compact('roles'));

        });
    }

    /**
     * Share view-specific nav links.
     *
     * @return void
     */
    private function shareNavLinks()
    {
        view()->composer(
            ['admin.products.images', 'admin.products.edit'],
            \Creuset\Composers\NavViewComposer::class.'@productLinks'
        );
    }

    /**
     * Share Post data with views.
     *
     * @return void
     */
    private function sharePostData()
    {
        view()->composer('admin.posts.index', \Creuset\Composers\Admin\PostViewComposer::class.'@postCount');
    }

    private function shareCountries()
    {
        view()->composer(['shop.checkout', 'addresses.form'], function ($view) {
            $countries_repository = $this->app->make(CountryRepository::class);

            $view->with('countries', $countries_repository->lists());
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
