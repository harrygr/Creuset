<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreateTermRequest;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Term;

class TermsController extends Controller
{
    /**
     * @var TermRepository
     */
    private $terms;

    public function __construct(TermRepository $terms)
    {
        $this->terms = $terms;
        $this->middleware('admin', ['only' => ['store', 'storeCategory', 'storeMany']]);
    }

    /**
     * Get all terms for a given taxonomy.
     * 
     * @param string $taxonomy
     * 
     * @return \Illuminate\Http\Response
     */
    public function terms($taxonomy)
    {
        $taxonomy = snake_case($taxonomy);

        return $this->terms->getTerms($taxonomy);
    }

    public function categories()
    {
        return $this->terms->getCategories();
    }

    public function tags()
    {
        return $this->terms->getTags();
    }

    /**
     * Create a new category in storage.
     * 
     * @param CreateTermRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(CreateTermRequest $request)
    {
        $attributes = [
            'term'     => $request->get('term'),
            'taxonomy' => 'category',
            'slug'     => $request->get('slug'),
        ];

        return Term::create($attributes);
    }

    /**
     * Create a new term in storage.
     * 
     * @param CreateTermRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTermRequest $request)
    {
        return Term::create($request->all());
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
        $term->delete();

        return 'success';
    }
}
