<?php

namespace Creuset\Repositories\User;

use TestCase;

class DbUserRepositoryTest extends TestCase
{
    private $users;

    public function setUp()
    {
        parent::setUp();
        $this->users = app(DbUserRepository::class);
    }

    /** @test **/
    public function it_creates_a_user()
    {
        $data = collect([
            'email'    => 'foo@example.com',
            'name'     => 'Joe Bloggs',
            'username' => 'joe_bloggs',
            'password' => 'secret',
                        ]);
        $user = $this->users->create($data);

        $this->assertFalse($user->autoCreated());
        $this->assertInstanceOf('Creuset\User', $user);
        $this->seeInDatabase('users', ['username' => 'joe_bloggs']);
    }

}
