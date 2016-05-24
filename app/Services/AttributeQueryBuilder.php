<?php

namespace App\Services;

use Illuminate\Http\Request;

class AttributeQueryBuilder
{
    /**
     * Filters to put in the query string.
     *
     * @var array
     */
    private $filters = [];

    private $currentFilters = [];

    /**
     * Create a new query builder instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->currentFilters = $request->query('filter') ?: [];
    }

    /**
     * Add a new filter to the query string.
     *
     * @param string $filter The attribute slug to filter by.
     * @param string $value  The value of the property.
     *
     * @return AttributeQueryBuilder
     */
    public function addFilter($filter, $value)
    {
        $this->filters[$filter] = $value;

        return $this;
    }

    /**
     * Explictly set the filters.
     *
     * @param array $filters
     *
     * @return AttributeQueryBuilder
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get the filter query string.
     *
     * @return string
     */
    public function getQueryString()
    {
        return http_build_query(['filter' => $this->getQueryFilters()]);
    }

    public function hasCurrentFilter($filter, $value = null)
    {
        return array_key_exists($filter, $this->currentFilters) and (is_null($value) or $this->currentFilters[$filter] === $value);
    }

    public function getQueryFilters()
    {
        $filters = array_merge($this->currentFilters, $this->filters);

        return array_filter($filters, function ($value, $key) {
            return !$this->filterAlreadyInRequest($key);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private function filterAlreadyInRequest($key)
    {
        return isset($this->filters[$key])
            and isset($this->currentFilters[$key])
            and $this->filters[$key] === $this->currentFilters[$key];
    }
}
