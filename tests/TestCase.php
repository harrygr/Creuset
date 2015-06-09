<?php

use Laracasts\Integrated\Extensions\Laravel as IntegrationTest;
use Laracasts\TestDummy\Factory as TestDummy;


abstract class TestCase extends IntegrationTest {

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
		Artisan::call('migrate', ['--seed']);
	}

	protected function createUser(array $overrides = [])
	{
		return TestDummy::create('Creuset\User', $overrides);
	}
}
