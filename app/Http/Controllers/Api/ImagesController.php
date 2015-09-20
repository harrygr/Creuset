<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Image;
use Creuset\Http\Requests;
use Illuminate\Http\Request;
use Creuset\Forms\AddImageToModel;
use Creuset\Http\Controllers\Controller;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic');
    }

    public function update(Request $request, Image $image)
    {
        $image->update($request->all());
        return 'Updated';       
    }

    /**
     * Store an image in the filesystem and attach it to its parent
     * @param  Request
     * @return Image The stored image
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg'
            ]);

        $post = $request->route('post');
        $file = $request->file('image');

        $image = (new AddImageToModel($post, $file))->save();
        return $image;
    }
}
