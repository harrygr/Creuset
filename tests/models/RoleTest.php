<?php

namespace App;

use TestCase;

class RoleTest extends TestCase
{
    /** @test **/
    public function it_enrolls_a_user()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'subscriber']);

        $user->enroll();

        $this->assertEquals('subscriber', $user->role->name);
        $this->assertTrue($user->hasRole('subscriber'));
    }

    /** @test **/
    public function it_assigns_a_role_to_a_user()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'customer']);

        $user->assignRole('customer');

        $this->assertEquals('customer', $user->role->name);
    }

    /** @test **/
    public function it_allows_assigning_a_base_role_that_hasnt_been_created()
    {
        $user = factory(User::class)->create();

        // pick the first base role available
        $role_name = array_keys(User::$base_roles)[0];

        $user->assignRole($role_name);

        $this->assertEquals($role_name, $user->role->name);
    }

    /** @test **/
    public function it_takes_exception_to_a_non_existant_role()
    {
        $user = factory(User::class)->create();

        $this->setExpectedException(\InvalidArgumentException::class);
        $user->assignRole('some_unknown_role');
    }

    /** @test **/
    public function it_formats_the_display_name_when_undefined()
    {
        $role = new Role(['name' => 'senior_vice-president']);

        $this->assertEquals('Senior Vice President', $role->display_name);
    }
}
