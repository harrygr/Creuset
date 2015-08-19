<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	use DatabaseMigrations;

	protected $baseUrl = 'http://homestead.app';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		// $this->setUpDatabase();

		return $app;
	}

	protected function setUpDatabase()
	{
		Artisan::call('migrate:reset');
		Artisan::call('migrate');
	}


	protected function loginWithUser(array $overrides = [])
	{
		$user = factory('Creuset\User')->create($overrides);
		\Auth::loginUsingId($user->id);
		return $user;
	}
}
