<?php namespace Integration;

use TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

	/**
	 * Simulate an HTTP request to upload an image to a post
	 */
	public function testItCanUploadAnImageToAPost()
	{
		$this->withoutMiddleware(); // needed to skip csrf checks etc
		
		// Make a post
		$post = factory('Creuset\Post')->create();

		// And we need a file
		$faker = Factory::create();
		$image = $faker->image();
		$file = new UploadedFile($image, basename($image), null, null, null, true);

		// Send off the request to upload the file
		$response = $this->call("POST", "/admin/posts/{$post->id}/image", [], [], ['image' => $file]);

		// An Image instance (in JSON) should be returned
		$responseData = json_decode($response->getContent());

		$this->assertFileExists(public_path($responseData->path));

		$this->seeInDatabase('images', [
			'post_id' => $post->id,
			'path'	=> $responseData->path,
			]);

		// Clean up the file
		\File::delete(public_path($responseData->path));
	}
}
