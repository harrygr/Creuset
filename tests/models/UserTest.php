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
}
