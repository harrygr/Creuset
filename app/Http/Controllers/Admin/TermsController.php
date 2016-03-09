<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Term\UpdateTermRequest;
use App\Repositories\Term\TermRepository;
use App\Term;

class TermsController extends Controller
{
    /**
     * The terms repository.
     *
     * @var \App\Repositories\Term\TermRepository
     */
    protected $terms;

    /**
     * Create a new TermsController instance.
     *
     * @param TermRepository $terms [description]
     */
    public function __construct(TermRepository $terms)
    {
        $this->terms = $terms;
    }

    /**
     * Show a page of all terms for a given taxonomy.
     *
     * @param string $taxonomies The singular or plural taxonomy to use
     *
     * @return \Illuminate\Http\Response
     */
    public function index($taxonomies)
    {
        $taxonomy = str_singular($taxonomies);

        if (!isset(Term::$taxonomies[$taxonomy])) {
            abort(404);
        }

        $terms = $this->terms->getTerms($taxonomy);
        $title = Term::$taxonomies[$taxonomy];

        return view('admin.terms.index')->with(compact('terms', 'title'));
    }

    /**
     * Show a list of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoriesIndex()
    {
        return $this->index('categories');
    }

    /**
     * Show a list of tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function tagsIndex()
    {
        return $this->index('tags');
    }

    /**
     * Show a page to edit a term.
     *
     * @param Term $term
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        return view('admin.terms.edit')->with(compact('term'));
    }

    /**
     * Update a term in storage.
     *
     * @param Term              $term
     * @param UpdateTermRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Term $term, UpdateTermRequest $request)
    {
        $term->update($request->all());

        $taxonomy = $term->getTaxonomy();

        return redirect()
            ->route('admin.terms.edit', $term)
            ->with(['alert' => "$taxonomy updated!", 'alert-class' => 'success']);
    }

    /**
     * Delete a term from storage.
     *
     * @param Term $term
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $oldTerm = $term;
        $taxonomy = $term->getTaxonomy();
        $term->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(['alert' => "$taxonomy \"{$oldTerm->term}\" deleted!", 'alert-class' => 'success']);
    }
}
