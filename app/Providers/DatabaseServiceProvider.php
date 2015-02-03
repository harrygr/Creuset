<?php namespace Creuset\Providers;

use Creuset\Post;
use Creuset\Repositories\Post\CachePostRepository;
use Creuset\Repositories\Post\DbPostRepository;
use Creuset\Repositories\Post\PostRepository;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider {

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
		$this->app->singleton(PostRepository::class, function()
		{
			return new CachePostRepository(
				new DbPostRepository(new Post)
			);
		});
	}

}
