<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase{

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

		$this->setUpDatabase();

		return $app;
	}

	protected function setUpDatabase()
	{	 
		Artisan::call('migrate:reset');
		Artisan::call('migrate');
		//Artisan::call('migrate', ['--seed']);
	}

	protected function createUser(array $overrides = [])
	{
		return factory('Creuset\User')->create($overrides);
	}
}
