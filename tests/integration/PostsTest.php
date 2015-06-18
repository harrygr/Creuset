<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase 
{

	use DatabaseTransactions;

	public function testICanCreateAPost()
	{
		// Given I have and account and am logged in
		$user = $this->createUser(['email' => 'user@example.com']);
		\Auth::loginUsingId($user->id);

		$this->visit('/admin/posts/create');

	}
}