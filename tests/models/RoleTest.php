<?php

namespace Creuset;

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
}
