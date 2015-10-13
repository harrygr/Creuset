<?php

namespace Creuset\Http\Controllers\Admin;


use Creuset\Image;
use Creuset\Http\Requests;
use Illuminate\Http\Request;
use Creuset\Http\Controllers\Controller;

class ImagesController extends Controller
{
    /**
     * Display a listing of images.
     *
     * @return Response
     */
    public function index()
    {
        $images = Image::latest()->paginate(10);
        return view('admin.images.index', compact('images'));
    }

    public function destroy($image)
    {
        \File::delete(public_path($image->path));
        \File::delete(public_path($image->thumbnail_path));

        $image->delete();

        return redirect()->route('admin.images.index')
                         ->with(['alert' => 'Image Deleted', 'alert-class' => 'success']);
    }

}
