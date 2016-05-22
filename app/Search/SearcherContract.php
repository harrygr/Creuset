<?php

namespace App\Search;

interface SearcherContract
{
    /**
     * Perform a search for some entities
     *
     * @param String $query
     *
     * @return Collection
     */
    public function search($query);

    /**
     * Return the results
     *
     * @return \Illuminate\Support\Collection
     */
    public function getResult();
}
