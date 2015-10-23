<?php

namespace Creuset\Http\Controllers\Admin;


use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Image;
use Illuminate\Http\Request;

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
        $image->delete();

        return redirect()->route('admin.images.index')
                         ->with(['alert' => 'Image Deleted', 'alert-class' => 'success']);
    }
}
