<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'terms';

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
}
