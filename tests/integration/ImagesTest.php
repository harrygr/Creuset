<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImagesTest extends TestCase
{

	use DatabaseTransactions;

	public function testCanUpdateAnImage()
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
		
	}

	public function testCannotUpdateAnImageIfNotAuthenticated()
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
		$response = $this->call('PATCH', '/api/images/' . $image->id, $newAttributes);

		$this->assertEquals(401, $response->getStatusCode()); //Unauthorized

		$this->notSeeInDataBase('images', ['id' => $image->id, 'title' => $newTitle]);
		
	}
}
