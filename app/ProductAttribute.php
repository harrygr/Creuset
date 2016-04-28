<?php

namespace App;

use App\Scopes\SortTermScope;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SortTermScope());

        /**
         * Set a slug on the term if it's not passed in.
         */
        static::creating(function ($attribute) {
            if (!$attribute->slug) {
                $attribute->slug = str_slug($attribute->name);
            }

            if (!$attribute->property_slug) {
                $attribute->property_slug = str_slug($attribute->property);
            }
        });
    }

    protected $table = 'product_attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'property', 'property_slug', 'order'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
