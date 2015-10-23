<?php

namespace Creuset\Forms;

use Creuset\Image;
use Creuset\Imageable;
use Creuset\Services\Thumbnailer;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddImageToModel {
	
	private $model;
	private $file;
	private $thumbnail;
	private $filesystem;

	public function __construct(Imageable $model, UploadedFile $file, Thumbnailer $thumbnail = null, Filesystem $filesystem = null)
	{
		$this->model = $model;
		$this->file = $file;
		$this->thumbnail = $thumbnail ?: new Thumbnailer;
		$this->filesystem = $filesystem ?: app(Filesystem::class);
	}

	public function save()
	{
		$image = $this->model->addImage($this->makeImage());
		
		$this->filesystem->put($image->path, file_get_contents($this->file));

		$this->thumbnail->make($this->file, $image->thumbnail_path);
		return $image;
	}

	protected function makeImage()
	{
		return new Image(['filename' => $this->makeFilename(), 'user_id' => \Auth::user()->id]);
	}

	protected function makeFilename()
	{
		return sprintf("%s_%s", time(), $this->file->getClientOriginalName());
	}
}