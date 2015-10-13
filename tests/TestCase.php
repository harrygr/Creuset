<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	use DatabaseMigrations;

	protected $baseUrl;


	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		$this->baseUrl = \Config::get('app.url', 'http://homestead.app');

		// $this->setUpDatabase();

		return $app;
	}

	protected function setUpDatabase()
	{
		Artisan::call('migrate:reset');
		Artisan::call('migrate');
	}

	protected function logInAsAdmin(array $overrides = [])
	{
		return $this->loginWithUser($overrides, 'admin');
	}

	protected function loginWithUser(array $overrides = [], $role = 'subscriber')
	{
		$user = factory('Creuset\User')->create($overrides);
		
		$user->assignRole($this->getRole($role)->name);

		\Auth::loginUsingId($user->id);
		return $user;
	}

	protected function getRole($role_name)
	{
		$role = Creuset\Role::where('name', $role_name)->first();
		if (!$role) {
			return Creuset\Role::create([
				'name' => $role_name, 
				'display_name' => ucwords($role_name),
				]);
		}
		return $role;
	}
}
