<?php namespace Integration;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TestCase;

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

	/** @test **/
	public function it_deletes_a_post()
	{
	    $this->withoutMiddleware();
	    
	    $user = $this->loginWithUser();
	    $post = factory('Creuset\Post')->create();

	    $this->visit("/admin/posts")
	    	 ->see($post->title);

	    // move to trash
	    $this->delete("/admin/posts/{$post->id}");

	    $this->visit("/admin/posts")
	     	 ->dontSee($post->title);

	    $this->visit("admin/posts/trash")
	         ->see($post->title);

	    // Delete permanently
	    $this->delete("/admin/posts/{$post->id}");
	    $this->notSeeInDatabase('posts', [
	    	'title' => $post->title
	    	]);
	}

		/** @test **/
	public function it_restores_a_post()
	{
	    $this->withoutMiddleware();
	    
	    $user = $this->loginWithUser();
	    $post = factory('Creuset\Post')->create();

	    // move to trash
	    $this->delete("/admin/posts/{$post->id}");
	    // restore
	    $this->put("/admin/posts/{$post->id}/restore");

	    $this->visit("/admin/posts")
	    	 ->see($post->title);
	}

	/**
	 * Simulate an HTTP request to upload an image to a post
	 */
	public function testItCanUploadAnImageToAPost()
	{
		$this->withoutMiddleware(); // needed to skip csrf checks etc
		$user = $this->loginWithUser();
		
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

		$this->assertTrue(Storage::exists($responseData->path));
		$this->assertTrue(Storage::exists($responseData->thumbnail_path));

		// Ensure the image has been saved in the db and attached to our post
		$this->seeInDatabase('images', [
			'imageable_id' => $post->id,
			'imageable_type' => 'Creuset\Post',
			'path'	=> $responseData->path,
			'user_id' => $user->id,
			]);

		// Clean up the file
		Storage::delete($responseData->path);
		Storage::delete($responseData->thumbnail_path);

	}
}
