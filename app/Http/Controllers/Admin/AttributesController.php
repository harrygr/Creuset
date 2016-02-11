<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Term;

class AttributesController extends Controller
{
    /**
     * Show all attributes.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::whereNotIn('taxonomy', array_keys(Term::$taxonomies))->get();

        $terms = $terms->groupBy('taxonomy');

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
        $taxonomy = str_singular($taxonomies);

        if (isset(Term::$taxonomies[$taxonomy]) or !Term::where('taxonomy', $taxonomy)->count()) {
            abort(404);
        }

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
        $terms = Term::where('taxonomy', $taxonomy)->delete();

        return redirect()->route('admin.attributes.index')->with([
            'alert'       => sprintf('Attribute "%s" deleted', \Present::labelText($taxonomy)),
            'alert-class' => 'success',
            ]);
    }
}
