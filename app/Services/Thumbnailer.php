<?php

namespace Creuset\Services;

class Thumbnailer {

	public function make($source, $destination)
	{
		\Image::make($source)
            ->fit(200)
            ->save($destination);
	}

}