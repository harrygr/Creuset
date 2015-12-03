<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreateTermRequest;
use Creuset\Repositories\Term\TermRepository;

class TermsController extends Controller
{
    /**
     * @var TermRepository
     */
    private $terms;

    public function __construct(TermRepository $terms)
    {
        $this->terms = $terms;
        $this->middleware('auth', ['only' => ['store', 'storeCategory']]);
    }

    public function terms($taxonomy)
    {
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

    public function storeCategory(CreateTermRequest $request)
    {
        return $this->terms->createCategory($request->get('term'));
    }

    public function store(CreateTermRequest $request)
    {
        return $this->terms->create($request->all());
    }
}
