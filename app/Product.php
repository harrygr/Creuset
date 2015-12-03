<?php

namespace Creuset;

use Carbon\Carbon;
use Creuset\Contracts\Termable;
use Creuset\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Creuset\Traits\Postable;

class Product extends Model implements HasMediaConversions, Termable 
{
	use PresentableTrait, HasMediaTrait, SoftDeletes, Postable;

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
             ->setManipulations(['w' => 300, 'h' => 300, 'fit' => 'crop'])
             ->performOnCollections('images');
    }

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
	protected $dates = ['created_at', 'updated_at', 'published_at', 'deleted_at'];

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

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

	protected $presenter = 'Creuset\Presenters\ProductPresenter';

	public function terms()
	{
		return $this->morphToMany('\Creuset\Term', 'termable');
	}

	public function product_categories()
	{
		return $this->morphToMany('\Creuset\Term', 'termable')
				    ->where('taxonomy', 'product_category');
	}

	/**
	 * Parses a date string into a Carbon instance for saving
	 * 
	 * This shouldn't really need to be done, but Laravel's automatic date
	 * mutators expects strings to be in the format Y-m-d H-i-s which is 
	 * not always the case; such as for 'datetime-local' html5 fields
	 * 
	 * @param mixed $date The date to be parsed
	 *
	 */
	public function setPublishedAtAttribute($date)
	{
		if (is_string($date)) {
			$this->attributes['published_at'] = new Carbon($date);
		}
	}

	public function setPriceAttribute($price)
	{
		$this->attributes['price'] = intval(100 * $price);
	}

	public function setSalePriceAttribute($price)
	{
		$this->attributes['sale_price'] = intval(100 * $price);
	}

	public function getPriceAttribute($price)
	{
		return $price / 100;
	}

	public function getSalePriceAttribute($price)
	{
		return $price / 100;
	}

	/**
	 * The field to use to display the parent name
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

}
