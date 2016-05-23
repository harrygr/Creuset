<?php

namespace App\Search;

interface SearcherContract
{
    /**
     * Perform a search for some entities.
     *
     * @param string $query
     *
     * @return Collection
     */
    public function search($query);

    /**
     * Return the results.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getResults();
}
