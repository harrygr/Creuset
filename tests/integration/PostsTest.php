<?php namespace Integration;

use TestCase;
use Laracasts\TestDummy\Factory as TestDummy;

class PostsTest extends TestCase {
	public function testICanCreateAPost()
	{
		// Given I have and account and am logged in
		$user = $this->createUser(['email' => 'user@example.com']);
		\Auth::loginUsingId($user->id);

		$this->visit('/admin/posts/create');

	}
}