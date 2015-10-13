<?php namespace Integration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use TestCase;

class ImagesTest extends TestCase
{

	use DatabaseTransactions;

	/** @test **/
	public function it_can_update_an_image()
	{
		// Given I have and account and am logged in
		$user = $this->loginWithUser();

		// And I have an image in the database
		$image = factory('Creuset\Image')->create();
		$newTitle = 'awesome image title';

		$newAttributes = [
			'title' => $newTitle
		];

		// We'll try and update the image
		$response = $this->call('PATCH', '/api/images/' . $image->id, $newAttributes);

		$this->assertEquals(200, $response->status());

		$this->seeInDataBase('images', ['id' => $image->id, 'title' => $newTitle]);
		$this->cleanUpImage($image);	
		
	}

	/** @test **/
	public function it_does_not_allow_updating_an_image_if_not_authenticated()
	{
		// Given I am not logged in
		auth()->logout();

		// And I have an image in the database
		$image = factory('Creuset\Image')->create();
		$newTitle = 'another awesome image title';

		$newAttributes = [
			'title' => $newTitle
		];

		// We'll try and update the image
		$response = $this->call('PATCH', "/api/images/{$image->id}", $newAttributes);

		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode()); //Unauthorized

		$this->notSeeInDataBase('images', ['id' => $image->id, 'title' => $newTitle]);

		$this->cleanUpImage($image);		
	}

	/** @test **/
	public function it_can_delete_an_image()
	{
		$this->withoutMiddleware();

	    // Given I have and account and am logged in
		$user = $this->loginWithUser();

		// And I have an image in the database
		$image = factory('Creuset\Image')->create();

		$this->delete('/admin/images/'.$image->id);

		$this->assertRedirectedToRoute('admin.images.index');		

		// Thehe database entry has been deleted
		$this->notSeeInDataBase('images', ['id' => $image->id, 'title' => $image->title]);

		// Ensure both image files have been deleted
		$this->assertFileNotExists($image->full_path);
		$this->assertFileNotExists($image->full_thumbnail_path);
	}

	private function cleanUpImage($image)
	{
		\File::delete($image->full_path);
		\File::delete($image->full_thumbnail_path);
	}

}
