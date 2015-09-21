<?php

namespace Creuset\Forms;

use Mockery;
use TestCase;
use Creuset\Post;
use Creuset\Services\Thumbnailer;
use Creuset\Forms\AddImageToModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* 
*/
class AddImageToModelTest extends TestCase {
	use DatabaseTransactions;

	/** @test **/
	public function it_processes_and_saves_an_image_to_a_model()
	{
		$post = factory(Post::class)->create();

		$thumbnail = Mockery::mock(Thumbnailer::class);

		$file = Mockery::mock(UploadedFile::class, [
			'getClientOriginalName' => 'foo.jpg'
			]);

		$thumbnail->shouldReceive('make')
		->once()
		->with(public_path('uploads/images/now_foo.jpg'), public_path('uploads/images/tn-now_foo.jpg'));

		$file->shouldReceive('move')
		->once()
		->with(public_path('uploads/images'), 'now_foo.jpg');

		$form = (new AddImageToModel($post, $file, $thumbnail))->save();

		$this->assertCount(1, $post->images);
	}
}

function time()
{
	return 'now';
}