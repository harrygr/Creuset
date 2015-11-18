<?php

namespace Creuset\Http\Controllers\Admin;


use Creuset\Contracts\Imageable;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of images.
     *
     * @return Response
     */
    public function index()
    {
        $images = Media::latest()->paginate(10);
        return view('admin.images.index', compact('images'));
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()->route('admin.images.index')
                         ->with(['alert' => 'Image Deleted', 'alert-class' => 'success']);
    }

}
