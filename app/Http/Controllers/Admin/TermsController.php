<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Term;

class TermsController extends Controller
{
    protected $terms;

    public function __construct(TermRepository $terms)
    {
        $this->middleware('auth');
        $this->terms = $terms;
    }

    public function categoriesIndex()
    {
        $terms = $this->terms->getCategories();
        $termName = 'Categories';

        return view('admin.terms.index')->with(compact('terms', 'termName'));
    }

    public function tagsIndex()
    {
        $terms = $this->terms->getTags();
        $termName = 'Tags';

        return view('admin.terms.index')->with(compact('terms', 'termName'));
    }

    public function edit($term)
    {
        # code...
    }

    public function update($term)
    {
        # code...
    }

    public function destroy(Term $term)
    {
        $oldTerm = $term;
        $taxonomy = ucfirst($term->taxonomy);
        $term->delete();
        
        return redirect()
            ->route('admin.categories.index')
            ->with(['alert' => "$taxonomy \"{$oldTerm->term}\" deleted!", 'alert-class' => 'success']);
    }
}
