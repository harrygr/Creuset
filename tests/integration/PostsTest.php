<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase 
{

	use DatabaseTransactions;

	public function testICanCreateAPost()
	{
		// Given I have and account and am logged in
		$user = factory('Creuset\User')->create();
		\Auth::loginUsingId($user->id);

		// I go to the create posts page
		$postTitle =  'Awesome Post Title';
		$postContent = 'Here is some post content';
		
		$this->visit('/admin/posts/create')
			 ->type($postTitle, 'title')
			 ->type(\Str::slug($postTitle), 'slug') //we'll manually type this even though js should generate this for us
			 ->type($postContent, 'content')
			 ->press('Create Post')
			 ->see('Post saved');

		// And see that I created a post successfully
		$this->seeInDatabase('posts', [
			'title' => $postTitle,
			'content' => $postContent,
			'type'	=> 'post',
			'user_id' => $user->id
			]);


	}
}