<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase 
{

	use DatabaseTransactions;

	function testCanLoginWithValidCredentials()
	{
    	// Assuming we have a user with these credentials
		$credentials = [
		'email'	=> 'jb@email.com',
		];

		$this->createUser($credentials);

		// We should be able to log in

		$this->visit('/login')
			 ->type($credentials['email'], 'email')
			 ->type('password', 'password')
			 ->press('Login')
			 ->seePageIs('/admin/posts');
	}

	function testCanNotLoginWithInvalidCredentials()
	{
		$this->visit('login')
			 ->type('fakename@noone.com', 'email')
			 ->type('wrongpw', 'password')
			 ->press('Login')
			 ->seePageIs('/login')
			 ->see('These credentials do not match our records');
	}

}