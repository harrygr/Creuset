<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Term;

class AttributesController extends Controller
{
    /**
     * Show all attributes
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::whereNotIn('taxonomy', array_keys(Term::$taxonomies))->get();

        $terms = $terms->groupBy('taxonomy');

        return view('admin.attributes.index', compact('terms'));
    }

    /**
     * Show a form for creating a new attribute
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    public function edit($taxonomies)
    {
        $taxonomy = str_singular($taxonomies);

        if (isset(Term::$taxonomies[$taxonomy]) or !Term::where('taxonomy', $taxonomy)->count()) {
            abort(404);
        }

        return view('admin.attributes.edit', compact('taxonomy'));
    }
}
