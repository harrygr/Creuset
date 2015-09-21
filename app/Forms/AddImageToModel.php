<?php

namespace Creuset\Forms;

use Creuset\Image;
use Creuset\Imageable;
use Creuset\Services\Thumbnailer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddImageToModel {
	
	private $model;
	private $file;
	private $thumbnail;

	public function __construct(Imageable $model, UploadedFile $file, Thumbnailer $thumbnail = null)
	{
		$this->model = $model;
		$this->file = $file;
		$this->thumbnail = $thumbnail ?: new Thumbnailer;
	}

	public function save()
	{
		$image = $this->model->addImage($this->makeImage());

		$this->file->move(public_path($image->baseDir()), $image->filename);

		$this->thumbnail->make(public_path($image->path), public_path($image->thumbnail_path));
		return $image;
	}

	protected function makeImage()
	{
		return new Image(['filename' => $this->makeFilename()]);
	}

	protected function makeFilename()
	{
		return sprintf("%s_%s", time(), $this->file->getClientOriginalName());
	}
}