<?php

namespace Creuset\Forms;

use Creuset\Forms\AddImageToModel;
use Creuset\Post;
use Creuset\Services\Thumbnailer;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TestCase;

/**
* 
*/
class AddImageToModelTest extends TestCase {
	use DatabaseTransactions;

	/** @test **/
	public function it_processes_and_saves_an_image_to_a_model()
	{
		$this->loginWithUser();
		$post = factory(Post::class)->create();

		$thumbnail = Mockery::mock(Thumbnailer::class);
		$filesystem = Mockery::mock(Filesystem::class);

		$file = Mockery::mock(UploadedFile::class, [
			'getClientOriginalName' => 'foo.jpg',
			]);

		$thumbnail->shouldReceive('make')
		->once()
		->with($file, 'uploads/images/tn-now_foo.jpg');

		$filesystem->shouldReceive('put')
		->once()
		->with('uploads/images/now_foo.jpg', 'abc123');

		$form = (new AddImageToModel($post, $file, $thumbnail, $filesystem))->save();

		$this->assertCount(1, $post->images);
	}
}

function time()
{
	return 'now';
}

function file_get_contents($file)
{
	return 'abc123';
}