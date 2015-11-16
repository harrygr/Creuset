<?php

namespace Creuset\Traits;

trait HasTerms 
{
	public function terms()
	{
		return $this->morphToMany('\Creuset\Term', 'termable');
	}

	public function categories()
	{
		return $this->morphToMany('\Creuset\Term', 'termable')
		->where('taxonomy', 'category');
	}

	public function tags()
	{
		return $this->morphToMany('\Creuset\Term', 'termable')
		->where('taxonomy', 'tag');
	}
}