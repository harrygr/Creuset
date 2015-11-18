<?php 

use Carbon\Carbon;
use Creuset\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response; 

class ApiMediaControllerTest extends TestCase
{

    use DatabaseTransactions;

    /** @test **/
    public function it_gets_the_images()
    {
        // new up some images
        $images = $this->createImage(3);

        $this->get('api/media')
             ->seeJson(['name' => $images->first()->name]);

        $images->first()->model->forceDelete();
    }

    /** @test **/
    public function it_gets_a_single_media_item()
    {
        $image = $this->createImage();

        $this->get('api/media/' . $image->id)
             ->seeJson(['name' => $image->name]);

        $image->model->forceDelete();
    }

}
