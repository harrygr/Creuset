<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Http\Controllers\Controller;

class AttributesController extends Controller
{
    /**
     * Show all attributes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Attribute::all()->groupBy('taxonomy');

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
     * @param string $taxonomies
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($taxonomies)
    {
        abort_if(!$this->isAttribute($taxonomy = str_singular($taxonomies)), 404);

        return view('admin.attributes.edit', compact('taxonomy'));
    }

    /**
     * Delete all instances of a given taxonomy from storage.
     *
     * @param string $taxonomy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($taxonomy)
    {
        $terms = Attribute::where('taxonomy', $taxonomy)->delete();

        return redirect()->route('admin.attributes.index')->with([
            'alert'       => sprintf('Attribute "%s" deleted', \Present::labelText($taxonomy)),
            'alert-class' => 'success',
            ]);
    }

    /**
     * Determine if a given taxonomy is a custom attribute (rather than a category, tag etc).
     *
     * @param string $taxonomy
     *
     * @return bool
     */
    protected function isAttribute($taxonomy)
    {
        return (bool) Attribute::where('taxonomy', $taxonomy)->count();
    }
}
