<?php

namespace App\Search;

class ProductSearcher extends Searcher implements SearcherContract
{
    /**
     * Get the type of entity to search for.
     * The search will filter the query to only get entities of the given type.
     *
     * @return string
     */
    protected function getSearchableType()
    {
        return 'product';
    }
}
