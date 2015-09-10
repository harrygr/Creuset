<?php

namespace Creuset\Http\Controllers\Api;

use Illuminate\Http\Request;
use Creuset\Image;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Image\ImageRepository;

class ImagesController extends Controller
{
    public function update(Request $request, Image $image)
    {
        $image->update($request->all());
        return 'Updated';       
    }
}
