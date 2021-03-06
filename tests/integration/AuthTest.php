<?php

namespace Integration;

use App\User;
use TestCase;

class AuthTest extends TestCase
{
    /** @test **/
    public function it_marks_a_user_as_not_auto_created_if_they_log_in_succesfully()
    {
        $email = 'jb@email.com';
        $user = factory(User::class)->create([
            'password' => 'password',
            'email'    => $email,
            ]);

        $this->visit('/login')
        ->type($email, 'email')
        ->type('password', 'password')
        ->press('Login')
        ->seePageIs('/');

        $this->assertTrue(\Auth::check());

        $this->assertFalse($user->fresh()->autoCreated());
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

        $this->assertTrue(\Auth::guest());
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
