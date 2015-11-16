<?php

namespace Creuset\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Thumbnailer {

	public function make(UploadedFile $source, $destination)
	{
		$image = Image::make(file_get_contents($source))
            		  ->fit(200)
            		  ->encode();

        Storage::put($destination, (string) $image);
	}

}