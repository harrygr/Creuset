<?php

namespace App\Providers;

use App\Countries\CountryRepository;
use App\Repositories\Order\OrderRepository;
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

        $this->shareProductIndexSettings();

        $this->shareOrderCountWithSidebar();

        $this->shareAttributes();
    }

    /**
     * Share a list of roles with the views that require it.
     *
     * @return void
     */
    private function shareRoles()
    {
        $this->app->view->composer('admin.users.form', function ($view) {

            $roles = \App\Role::lists('display_name', 'id');

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
        $this->app->view->composer(
            ['admin.products.images', 'admin.products.edit'],
            \App\Composers\NavViewComposer::class.'@productLinks'
        );
    }

    /**
     * Share Post data with views.
     *
     * @return void
     */
    private function sharePostData()
    {
        $this->app->view->composer('admin.posts.index', \App\Composers\Admin\PostViewComposer::class.'@postCount');
    }

    private function shareCountries()
    {
        $this->app->view->composer(['shop.checkout', 'addresses.form'], function ($view) {
            $countries_repository = $this->app->make(CountryRepository::class);

            $view->with('countries', $countries_repository->lists());
        });
    }

    /**
     * Share configuration pertinant to displaying a list of products.
     *
     * @return void
     */
    private function shareProductIndexSettings()
    {
        $this->app->view->composer('shop.index', function ($view) {
            $view->with('products_per_row', config('shop.products_per_row'));
        });
    }

    private function shareOrderCountWithSidebar()
    {
        $this->app->view->composer('admin.layouts.sidebar-menu', function ($view) {
            $orders = $this->app->make(OrderRepository::class);
            $view->with('order_count', $orders->count(\App\Order::PAID));
        });
    }

    private function shareAttributes()
    {
        $this->app->view->composer('admin.products.form.attributes', function ($view) {
            $view->with('attributes', \App\Attribute::all()->groupBy('taxonomy'));
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
