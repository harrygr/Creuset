<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Image;
use Illuminate\Http\Request;
use Creuset\Contracts\Imageable;
use Creuset\Forms\AddImageToModel;
use Creuset\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;

class ImagesController extends Controller
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->middleware('auth.basic', ['only' => ['store', 'update', 'destroy']]);
        $this->filesystem = $filesystem;
    }

    public function index()
    {
        return Image::paginate();
    }

    public function show(Image $image)
    {
        return $image;
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
    public function store(Imageable $imageable, Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg'
            ]);

        $file = $request->file('image');

        $image = (new AddImageToModel($imageable, $file))->save();

        return $image;
    }

    public function destroy(Image $image)
    {
        $image->deleteFiles();
        $image->delete();
        return 'Image Deleted';
    }

    public function images(Imageable $imageable)
    {
        return $imageable->images;
    }
}
