<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Term;

class TermsController extends Controller
{
    protected $terms;

    public function __construct(TermRepository $terms)
    {
        $this->terms = $terms;
    }

    public function index($taxonomies)
    {
        $taxonomy = str_singular($taxonomies);
        $terms = $this->terms->getTerms($taxonomy);
        if (!isset(Term::$taxonomies[$taxonomy])) {
            abort(404);
        }
        $term_name = Term::$taxonomies[$taxonomy];

        return view('admin.terms.index')->with(compact('terms', 'term_name'));
    }

    public function categoriesIndex()
    {
        $terms = $this->terms->getCategories();
        $term_name = 'Categories';

        return view('admin.terms.index')->with(compact('terms', 'term_name'));
    }

    public function tagsIndex()
    {
        $terms = $this->terms->getTags();
        $term_name = 'Tags';

        return view('admin.terms.index')->with(compact('terms', 'term_name'));
    }

    public function productCategoriesIndex()
    {
        $terms = $this->terms->getTags();
        $term_name = 'Tags';

        return view('admin.terms.index')->with(compact('terms', 'term_name'));
    }

    public function edit($term)
    {
        // code...
    }

    public function update($term)
    {
        // code...
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
