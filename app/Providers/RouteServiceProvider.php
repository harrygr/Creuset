<?php namespace Creuset\Providers;

use Creuset\Post;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider {

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
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		$router->model('term', 'Creuset\Term');
		$router->model('user', 'Creuset\User');
		$router->model('image', 'Creuset\Image');
		$router->model('post', 'Creuset\Post');
		$router->model('product', 'Creuset\Product');
		
		$router->bind('trashedPost', function($id) {
			return Post::withTrashed()->find($id);
		});

		$router->bind('username', function($username)
		{
			return \Creuset\User::where('username', $username)->firstOrFail();
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
