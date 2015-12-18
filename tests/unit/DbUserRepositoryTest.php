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
            'email' => 'foo@example.com',
            'name' => 'Joe Bloggs',
            'username' => 'joe_bloggs',
            'password' => 'secret'
                        ]);
        $user = $this->users->create($data);

        $this->assertFalse($user->auto_created);
        $this->assertInstanceOf('Creuset\User', $user);
        $this->seeInDatabase('users', ['username' => 'joe_bloggs']);
    }

    /** @test **/
    public function it_auto_creates_a_user_from_just_a_name_and_email()
    {
        $data = collect([
            'email' => 'foo2@example.com',
            'name' => 'John Snow',
                        ]);
        $user = $this->users->create($data);

        $this->assertTrue($user->auto_created);
        $this->assertInstanceOf('Creuset\User', $user);
        $this->seeInDatabase('users', ['username' => 'foo2@example.com', 'email' => 'foo2@example.com']);
    }
}