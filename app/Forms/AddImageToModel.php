<?php

namespace Creuset\Forms;

use Creuset\Image;
use Creuset\Imageable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddImageToModel {
	
	private $model;
	private $file;

	public function __construct(Imageable $model, UploadedFile $file)
	{
		$this->model = $model;
		$this->file = $file;
	}

	public function save()
	{
		$image = $this->model->addImage($this->makeImage());

		$this->file->move(public_path($image->baseDir()), $image->filename);

		$image->makeThumbnail();

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