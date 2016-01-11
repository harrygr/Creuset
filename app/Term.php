<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'terms';

    /**
     * The taxonomies in use.
     *
     * @var array
     */
    public static $taxonomies = [
        'category'            => 'Categories',
        'tag'                 => 'Tags',
        'product_category'    => 'Product Categories',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxonomy', 'term', 'slug'];

    public function posts()
    {
        return $this->morphedByMany('Creuset\Post', 'termable');
    }

    public function products()
    {
        return $this->morphedByMany('Creuset\Product', 'termable');
    }

    public function getTermAttribute($term)
    {
        if (!$term) {
            return ucwords(\Present::unslug($this->slug));
        }
        return $term;
    }
}
