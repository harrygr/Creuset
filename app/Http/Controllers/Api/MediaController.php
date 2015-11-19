<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Media;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class MediaController extends Controller
{
    public function index($collection = null)
    {
        if ($collection) {
            return Media::whereCollectionName($collection)->paginate();
        }
        return Media::paginate();
    }

    public function show(Media $media)
    {
        return $media;
    }

    public function store(HasMedia $model, Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg'
            ]);
        $file = $request->file('image');

        return $model->addMedia($file)->toCollection('images');
    }

    public function update(Media $media, Request $request)
    {
        dd($resquest->all());
    }
    public function modelImages(HasMedia $model)
    {

        return $model->getMedia();
    }


    public function destroy(Media $media)
    {
        $media->delete();

        return 'Deleted';
    }
}
