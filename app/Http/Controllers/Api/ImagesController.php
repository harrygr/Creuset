<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Forms\AddImageToModel;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Intervention;

class ImagesController extends Controller
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->middleware('auth.basic');
        $this->filesystem = $filesystem;
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
