<?php

namespace App;

use App\Contracts\Termable;
use App\Presenters\PresentableTrait;
use App\Traits\Postable;
use App\Traits\SearchableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Product extends Model implements HasMediaConversions, Termable, \Spatie\SearchIndex\Searchable
{
    use PresentableTrait, HasMediaTrait, SoftDeletes, Postable, SearchableModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'products';

    /**
     * Set the image sizes for product attachments.
     *
     * @return void
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
             ->setManipulations(['w' => 300, 'h' => 300, 'fit' => 'crop'])
             ->performOnCollections('images');

        $this->addMediaConversion('wide')
             ->setManipulations(['w' => 1300, 'h' => 866, 'fit' => 'crop'])
             ->performOnCollections('images');
    }

    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function media()
    {
        return $this->morphMany(config('laravel-medialibrary.media_model'), 'model')->orderBy('order_column', 'ASC');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'published_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name',
    'slug',
    'description',
    'user_id',
    'media_id',
    'status',
    'price',
    'sale_price',
    'sku',
    'stock_qty',
    'published_at',
    ];

    protected $presenter = 'App\Presenters\ProductPresenter';

    /**
     * Get all the terms for a product
     * Restrict only to normal taxonomies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function terms()
    {
        return $this->morphToMany(Term::class, 'termable');
    }

    /**
     * Get all the attributes for a product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function product_attributes()
    {
        return $this->belongsToMany(ProductAttribute::class);
    }

    /**
     * Add an attribute to a product.
     *
     * @param Term $attribute
     */
    public function addProperty(ProductAttribute $attribute)
    {
        $this->product_attributes()->save($attribute);

        return $this;
    }

    /**
     * A product belongs to many product categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function product_categories()
    {
        return $this->morphToMany(Term::class, 'termable')
                    ->where('taxonomy', 'product_category');
    }

    /**
     * Ensure an uncategorised term exists and assign it to the product,
     * removing it from all other categories.
     *
     * @return Product
     */
    public function makeUncategorised()
    {
        $term = Term::firstOrCreate([
              'taxonomy' => 'product_category',
              'slug'     => 'uncategorised',
              'term'     => 'Uncategorised',
              ]);

        return $this->syncTerms([$term->id]);
    }

    /**
     * Sync terms to a product.
     *
     * @param \Illuminate\Database\Eloquent\Collection|array $terms
     *
     * @return Product
     */
    public function syncTerms($terms = [])
    {
        if (!count($terms)) {
            return $this->makeUncategorised();
        }

        if ($terms instanceof \Illuminate\Database\Eloquent\Collection) {
            $terms = $terms->pluck('id')->toArray();
        }
        $this->product_categories()->sync($terms);

        // $this->product_categories()->detach($this->product_categories->pluck('id'));
        // $this->product_categories()->attach($terms);

        return $this;
    }

    /**
     * Sync attributes to a product.
     *
     * @param \Illuminate\Database\Eloquent\Collection|array $terms
     *
     * @return Product
     */
    public function syncAttributes($attributes = [])
    {
        if ($attributes instanceof \Illuminate\Database\Eloquent\Collection) {
            $attributes = $attributes->pluck('id')->toArray();
        }

        $this->product_attributes()->sync($attributes);

        return $this;
    }

    /**
     * A product belongs to a featured image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    /**
     * Apply the attribute filter scope.
     *
     * @param Builder                $query
     * @param ProductAttributeFilter $filter
     *
     * @return Builder
     */
    public function scopeFilter($query, ProductAttributeFilter $filter)
    {
        return $filter->apply($query);
    }

    /**
     * Limit the query to only sale items.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOnSale($query)
    {
        return $query->where('sale_price', '>', 0);
    }

    /**
     * Parses a date string into a Carbon instance for saving.
     *
     * This shouldn't really need to be done, but Laravel's automatic date
     * mutators expects strings to be in the format Y-m-d H-i-s which is
     * not always the case; such as for 'datetime-local' html5 fields.
     *
     * @param mixed $date The date to be parsed
     */
    public function setPublishedAtAttribute($date)
    {
        if (is_string($date)) {
            $this->attributes['published_at'] = new Carbon($date);
        }
    }

    /**
     * Get the URL of the product's thumbnail.
     *
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return $this->image ? $this->image->thumbnail_url : '';
    }

    /**
     * Cast the product's price to an integer for storage.
     *
     * @param float $price
     */
    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = intval(100 * $price);
    }

    /**
     * Cast the product's sale price to an integer for storage.
     *
     * @param float $price
     */
    public function setSalePriceAttribute($price)
    {
        $this->attributes['sale_price'] = intval(100 * $price);
    }

    /**
     * Cast the product's price to a float.
     *
     * @param int $price
     *
     * @return float
     */
    public function getPriceAttribute($price)
    {
        return $price / 100;
    }

    /**
     * Cast the product's sale price to a float.
     *
     * @param int $price
     *
     * @return float
     */
    public function getSalePriceAttribute($price)
    {
        return $price / 100;
    }

    /**
     * Get the product's description as html.
     *
     * @return string
     */
    public function getDescriptionHtml()
    {
        return \Markdown::convertToHtml($this->description);
    }

    /**
     * Get the URL to a single product page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return sprintf('/shop/%s/%s', $this->product_category->slug, $this->slug);
    }

    /**
     * The field to use to display the parent name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the product's product category.
     * Gets the first if more than one set.
     * Sets it to uncategorised if none set.
     *
     * @return \App\Term
     */
    public function getProductCategoryAttribute()
    {
        if ($this->product_categories->count() == 0) {
            $this->makeUncategorised();

            return $this->fresh()->product_categories->first();
        }

        return $this->product_categories->first();
    }

    /**
     * Get the price of the product.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->sale_price > 0 ? $this->sale_price : $this->price;
    }

    /**
     * Get whether a product is in stock.
     *
     * @return bool
     */
    public function inStock()
    {
        return $this->stock_qty > 0;
    }

    /** SEARCH **/
    /**
     * Returns an array with properties which must be indexed
     *
     * @return array
     */
    public function getSearchableBody()
    {
        return [
            'name' => $this->name,
            'id'   => $this->id,
            'url'  => $this->url,
            'image_url' => $this->present()->thumbnail_url,
            'description' => $this->description,
            'categories' => $this->product_categories->pluck('term'),
            'attributes' => $this->product_attributes->groupBy('name')->map(function($group) {
                return $group->pluck('property');
            }),
            'type'  => $this->getSearchableType(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    /**
     * Return the type of the searchable subject
     *
     * @return string
     */
    public function getSearchableType()
    {
        return 'product';
    }

    /**
     * Return the id of the searchable subject
     *
     * @return string
     */
    public function getSearchableId()
    {
        return $this->id;
    }
}
