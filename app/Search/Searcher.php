<?php

namespace App\Search;

use Illuminate\Support\Collection;
use Spatie\SearchIndex\Query\Algolia\SearchQuery;

abstract class Searcher {

    /**
     * The results as returned from the API
     *
     * @var Array
     */
    protected $results = [];

    /**
     * Get the type of entity to search for.
     * The search will filter the query to only get entities of the given type.
     *
     * @return String
     */
    abstract protected function getSearchableType();

    /**
     * Perform a search for some entities
     *
     * @param String $query
     *
     * @return Collection
     */
    public function search($query)
    {
        $query = (new SearchQuery())->searchFor($query);
        $query->withFacet('type', $this->getSearchableType());

        $this->results = \SearchIndex::getResults($query);

        return $this;
    }

    /**
     * Return the results
     *
     * @return Collection
     */
    public function getResult()
    {
        return new Collection($this->results['hits']);
    }
}
