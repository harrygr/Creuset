<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of images.
     *
     * @return Response
     */
    public function index()
    {
        $media = Media::latest()->paginate(10);

        return view('admin.media.index', compact('media'));
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()->route('admin.media.index')
                         ->with(['alert' => 'Image Deleted', 'alert-class' => 'success']);
    }
}
