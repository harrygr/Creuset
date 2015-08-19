<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{

	use DatabaseTransactions;

	/**
	 * Test a user can login with their credentials and is taken to the right page.
	 */
	function testCanLoginWithValidCredentials()
	{
    	// Assuming we have a user with these credentials
		$credentials = [
		'email'	=> 'jb@email.com',
		];

		factory('Creuset\User')->create($credentials);

		echo "hello";

		// We should be able to log in
		// (The factory-defined password is 'password')

		$this->visit('/login')
			 ->type($credentials['email'], 'username')
			 ->type('password', 'password')
			 ->press('Login')
			 ->seePageIs('/admin/posts');
	}

	/**
	 * Test that invalid credentials provides the correct response when trying to login
	 */
	function testCanNotLoginWithInvalidCredentials()
	{
		$this->visit('login')
			 ->type('fakename@noone.com', 'username')
			 ->type('wrongpw', 'password')
			 ->press('Login')
			 ->seePageIs('/login')
			 ->see('These credentials do not match our records');
	}

}
