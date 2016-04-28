<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductAttribute;

class AttributesController extends Controller
{
    /**
     * Show all attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = ProductAttribute::all()->groupBy('slug');

        return view('admin.attributes.index', compact('terms'));
    }

    /**
     * Show a form for creating a new attribute.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Show a form for updating attribute terms.
     *
     * @param string $attribute_slug
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Delete all instances of a given taxonomy from storage.
     *
     * @param string $taxonomy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $terms = ProductAttribute::where('slug', $slug)->delete();

        return redirect()->route('admin.attributes.index')->with([
            'alert'       => sprintf('Attribute "%s" deleted', \Present::labelText($slug)),
            'alert-class' => 'success',
            ]);
    }
}
