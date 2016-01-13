<?php

namespace Creuset\Providers;

use Creuset\Post;
use Creuset\Product;
use Creuset\Term;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Creuset\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('term', 'Creuset\Term');
        $router->model('user', 'Creuset\User');
        $router->model('post', 'Creuset\Post');
        $router->model('media', 'Creuset\Media');
        $router->model('address', 'Creuset\Address');

        $router->bind('product', function ($id) {
            $products = $this->app->make(\Creuset\Repositories\Product\ProductRepository::class);

            return $products->fetch($id, ['product_categories', 'image']);
        });

        $router->bind('order', function ($id) {
            return \Creuset\Order::with(['items', 'shipping_address', 'billing_address'])->findOrFail($id);
        });

        $router->bind('trashedPost', function ($id) {
            return Post::withTrashed()->find($id);
        });

        $router->bind('username', function ($username) {
            return \Creuset\User::where('username', $username)->firstOrFail();
        });

        $router->bind('product_slug', function ($slug) {
            return Product::where('slug', $slug)->firstOrFail();
        });

        $router->bind('product_category', function ($slug) {
            return Term::where([
                'taxonomy' => 'product_category',
                'slug'     => $slug,
                ])->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->loadRoutesFrom(app_path('Http/routes.php'));
    }
}
