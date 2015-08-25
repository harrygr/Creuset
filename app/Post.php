<?php namespace Creuset;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Creuset\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

	use PresentableTrait, SoftDeletes;
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
	protected $dates = ['created_at', 'updated_at', 'published_at', 'deleted_at'];

	protected $presenter = 'Creuset\Presenters\PostPresenter';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'slug', 'content', 'user_id', 'post_id', 'type', 'status', 'published_at'];

	public static $postStatuses = [
		'published'	=> 'Published',
		'draft'		=> 'Draft',
		'private'	=> 'Private',
	];

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
		if (is_string($date))
			$this->attributes['published_at'] = new Carbon($date);
	}

	public function getUserIdAttribute($userId)
	{
		return $userId ?: \Auth::user()->id;
	}


	public function author()
	{
		return $this->belongsTo('\Creuset\User', 'user_id', 'id');
	}

	public function parent()
	{
		return $this->belongsTo('\Creuset\Post');
	}

	public function children()
	{
		return $this->hasMany('\Creuset\Post');
	}

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

	public function images()
	{
		return $this->hasMany('\Creuset\Image');
	}

	public function addImage(\Creuset\Image $image)
	{
		return $this->images()->save($image);
	}

}
