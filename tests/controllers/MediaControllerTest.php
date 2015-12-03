<?php

use Carbon\Carbon;
use Creuset\Media;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaControllerTest extends TestCase
{

	use DatabaseTransactions;

    /** @test **/
    public function it_shows_the_media_index_page()
    {
        // new up some images
        $images = $this->createImage(3);

        $this->visit('admin/media')
             ->see($images->first()->title);

        $images->first()->model->forceDelete();
    }

    /** @test **/
    public function it_allows_deleting_a_media_item()
    {
    	$this->withoutMiddleware();
    	$image = $this->createImage();

    	// simulate clicking 'delete' for a given media item
    	$this->delete("admin/media/{$image->id}");

    	$this->assertRedirectedTo('admin/media');
    	$this->assertSessionHas(['alert' => 'Image Deleted']);

    	$this->notSeeInDatabase('media', ['name' => $image->name]);
    }
	
}
