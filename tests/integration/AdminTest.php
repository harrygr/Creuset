<?php namespace Integration;

use TestCase;
use Laracasts\TestDummy\Factory as TestDummy;

class AdminTest extends TestCase {

	function testCanLoginWithValidCredentials()
	{
    	// Assuming we have a user with these credentials
		$credentials = [
		'email'	=> 'jb@email.com',
		];

		$this->createUser($credentials);

		// We should be able to log in
		$credentials += ['password' => 'password'];

		$this->visit('/login')
			 ->andSubmitForm('Login', $credentials)
			 ->andSeePageIs('/admin/posts');
	}

	function testCanNotLoginWithInvalidCredentials()
	{
		$this->visit('login')
			->andSubmitForm('Login', ['email' => 'fakename@noone.com', 'password' => 'wrongpw'])
			->andSeePageIs('/login')
			->andSee('These credentials do not match our records');
	}


}