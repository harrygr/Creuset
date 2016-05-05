<?php

namespace App;

use TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_verifies_if_a_user_has_been_auto_created()
    {
        $user = factory(User::class)->create();
        $user->last_seen_at = null;
        $user->save();

        $this->assertTrue($user->autoCreated());

        \Auth::attempt(['email' => $user->email, 'password' => 'password']);

        $this->assertFalse($user->fresh()->autoCreated());
    }

    /** @test **/
    public function it_gets_admin_users_based_on_the_config_value()
    {
        $admin_user1 = factory(User::class)->create();
        $admin_user2 = factory(User::class)->create();

        $normal_user = factory(User::class)->create();

        // Set the dummy config value
        config(['shop.admins' => sprintf('%s,%s', $admin_user1->id, $admin_user2->email)]);

        $admins = User::shopAdmins()->get();

        $this->assertCount(2, $admins);
        $this->assertTrue($admins->contains('id', $admin_user1->id));
        $this->assertTrue($admins->contains('email', $admin_user2->email));
        $this->assertFalse($admins->contains('id', $normal_user->id));
    }
}
