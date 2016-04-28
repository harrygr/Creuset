<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductAttributeFilter
{
    private $filters;

    private $builder;

    public function __construct(Request $request)
    {
        $this->filters = collect($request->get('filter', []));
    }

    /**
     * Apply the attribute filter to the builder
     * 
     * @param  Builder $builder
     * 
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters as $attribute => $property) {

            $this->builder->whereHas('product_attributes', function($query) use ($attribute, $property) {
                $query->where('slug', $attribute)
                      ->where('property_slug', $property);
            });
            
        }
        return $this->builder;
    }


}