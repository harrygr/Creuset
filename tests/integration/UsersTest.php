<?php

namespace Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanEditUserProfile()
    {
        $this->loginWithUser();

        $newUserProfile = $this->newUserProfile();

        $this->updateProfile($newUserProfile);

        $this->seePageIs('/admin/profile')
             ->see('Profile updated');

        $this->seeInDatabase('users', [
            'name'        => $newUserProfile['name'],
            'username'    => $newUserProfile['username'],
            'email'       => $newUserProfile['email'],
            ]);
    }

    public function testItDoesntAllowSavingUniqueFields()
    {
        $currentUser = $this->loginWithUser();

        // Make a new user in the database
        $newUserProfile = $this->newUserProfile();
        factory('Creuset\User')->create($newUserProfile);

        // Try to update our own profile with info from the already existant user
        $this->updateProfile($newUserProfile);

        // Check for error messages
        $this->seePageIs('/admin/profile')
             ->see('email has already been taken')
             ->see('username has already been taken');

        // Ensure we haven't updated the user in the database
        $this->notSeeInDatabase('users', [
            'id'       => $currentUser->id,
            'username' => $newUserProfile['username'],
            ]);
    }

    private function updateProfile($overrides = [])
    {
        $newUserProfile = array_merge($this->newUserProfile(), $overrides);

        $this->visit('/admin/profile')
             ->type($newUserProfile['name'], 'name')
             ->type($newUserProfile['username'], 'username')
             ->type($newUserProfile['email'], 'email')
             ->type('secret123', 'password')
             ->type('secret123', 'password_confirmation')
             ->press('Update Profile');
    }

    private function newUserProfile()
    {
        return factory('Creuset\User')->make()->toArray();
    }
}
