<?php

namespace App\Traits;

trait HasTerms
{
    public function terms()
    {
        return $this->morphToMany('\App\Term', 'termable');
    }

    public function categories()
    {
        return $this->morphToMany('\App\Term', 'termable')
        ->where('taxonomy', 'category');
    }

    public function tags()
    {
        return $this->morphToMany('\App\Term', 'termable')
        ->where('taxonomy', 'tag');
    }
}
