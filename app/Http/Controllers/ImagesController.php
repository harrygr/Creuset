<?php

namespace Creuset\Http\Controllers;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;

class ImagesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        $file = Storage::get($image->path);
        return Intervention::make($file)->response();
    }
}
