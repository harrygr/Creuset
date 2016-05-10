<?php

namespace Integration;

use TestCase;

class UsersTest extends TestCase
{
    /** @test **/
    public function it_can_create_a_new_user()
    {
        $this->logInAsAdmin();

        $this->visit('/admin/users/new')
             ->type('Joe Bloggs', 'name')
             ->type('joebloggs', 'username')
             ->type('joe@bloggs.com', 'email')
             ->type('secret123', 'password')
             ->type('secret123', 'password_confirmation')
             ->press('Create User');

        $this->seeInDatabase('users', [
            'username'    => 'joebloggs',
            'email'       => 'joe@bloggs.com',
            ]);

        // Ensure the password has been saved and hashed correctly
        $this->assertTrue(\Auth::validate([
            'email'    => 'joe@bloggs.com',
            'password' => 'secret123',
            ]));
    }

    /** @test **/
    public function it_can_edit_its_own_user_profile()
    {
        $currentUser = $this->logInAsAdmin();

        $newUserProfile = factory('App\User')->make()->toArray();

        $this->updateProfile($newUserProfile);

        $this->seePageIs('/admin/profile')
             ->see('Profile updated');

        $this->seeInDatabase('users', [
            'name'        => $newUserProfile['name'],
            'username'    => $newUserProfile['username'],
            'email'       => $newUserProfile['email'],
            ]);

        // Ensure the password has been saved and hashed correctly
        $this->assertTrue(\Auth::validate([
            'email'    => $newUserProfile['email'],
            'password' => 'secret123',
            ]));
    }

    /** @test **/
    public function it_does_not_allow_user_details_that_are_already_taken()
    {
        $currentUser = $this->logInAsAdmin();

        // Make a new user in the database
        $newUserProfile = $this->newUserProfile();
        factory('App\User')->create($newUserProfile);

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

    /** @test **/
    public function it_shows_the_orders_for_a_user()
    {
        $order_item = factory(\App\OrderItem::class)->create();

        $user = $order_item->order->customer;

        $this->logInAsAdmin();

        $this->visit("admin/users/{$user->username}/orders")
             ->see("#{$order_item->id}");
    }

    /** @test **/
    public function it_shows_the_addresses_for_a_user()
    {
        $address = factory(\App\Address::class)->make();
        $user = factory(\App\User::class)->create();

        $user->addresses()->save($address);

        $this->logInAsAdmin();

        $this->visit("admin/users/{$user->username}/addresses")
             ->see($address->line_1);
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
        return factory('App\User')->make()->toArray();
    }
}
