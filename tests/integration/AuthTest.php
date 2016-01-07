<?php

namespace Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_login_with_valid_credentials()
    {
        $credentials = [
        'email' => 'jb@email.com',
        ];

        $user = factory('Creuset\User')->create($credentials);

        $this->visit('/login')
        ->type($credentials['email'], 'email')
        ->type('password', 'password')
        ->press('Login')
        ->seePageIs('/');
    }

    /** @test **/
    public function it_cannot_login_with_invalid_credentials()
    {
        $this->visit('login')
        ->type('fakename@noone.com', 'email')
        ->type('wrongpw', 'password')
        ->press('Login')
        ->seePageIs('/login')
        ->see('These credentials do not match our records');
    }

    /** @test **/
    public function it_throttles_invalid_logins()
    {
        $this->visit('login');

        foreach (range(0, 5) as $attempt) {
            $this->type('fakename@noone.com', 'email')
                 ->type('wrongpw', 'password')
                 ->press('Login');
        }

        $this->seePageIs('/login')
             ->see('Too many login attempts');
    }
}
