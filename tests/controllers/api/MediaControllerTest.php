<?php

namespace App\Http\Controllers\Api;

class MediaControllerTest extends \TestCase
{
    /** @test **/
    public function it_gets_the_images()
    {
        // new up some images
        $images = $this->createImage(3);

        $this->get('api/media')
             ->seeJson(['name' => $images->first()->name]);

        // deleting the parent model will also delete the child images
        $images->first()->model->forceDelete();
    }

    /** @test **/
    public function it_gets_a_single_media_item()
    {
        $image = $this->createImage();

        $this->get('api/media/'.$image->id)
             ->seeJson(['name' => $image->name]);

        $image->model->forceDelete();
    }
}
