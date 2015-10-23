<?php

namespace Creuset\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class Thumbnailer {

	public function make($source, $destination)
	{
        //$file = Storage::get($source);
		$image = Image::make(file_get_contents($source))
            ->fit(200)->encode();

            //->save($destination);
        Storage::put($destination, (string) $image);
	}

}