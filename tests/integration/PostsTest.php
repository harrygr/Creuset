<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{

	use DatabaseTransactions;

	public function testICanCreateAPost()
	{
		// Given I have and account and am logged in
		$user = $this->loginWithUser();

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

	public function testICanEditAPost()
	{
		// Given I have and account and am logged in
		$user = $this->loginWithUser();

		// And a post exists in the database
		$post = factory('Creuset\Post')->create();

		// I update the post
		$postTitle =  'Edited Title';

		$this->visit("/admin/posts/{$post->id}/edit")
			 ->see('Edit Post')
			 ->type($postTitle, 'title')
			 ->type(\Str::slug($postTitle), 'slug')
			 ->press('Update')
			 ->seePageIs("/admin/posts/{$post->id}/edit")
			 ->see('Post Updated');

        // And see that I edited the post successfully
		$this->seeInDatabase('posts', [
			'id'	=> $post->id,
			'title' => $postTitle,
			'type'	=> 'post'
			]);
	}
}
