<?php namespace Creuset;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Creuset\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

	use PresentableTrait, SoftDeletes;
	
	protected $dates = ['published_at', 'deleted_at'];

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

	public function setPublishedAtAttribute($date)
	{
		$this->attributes['published_at'] = Carbon::parse($date);
	}
	public function getPublishedAtAttribute($date)
	{
		return new Carbon($date);
	}

	public function getUserIdAttribute($userId)
	{
		return $userId ?: \Auth::user()->id;
	}


	public function author()
	{
		return $this->belongsTo('Creuset\User', 'user_id', 'id');
	}

	public function parent()
	{
		return $this->belongsTo('Creuset\Post');
	}

	public function children()
	{
		return $this->hasMany('Creuset\Post');
	}

	public function terms()
	{
		return $this->morphToMany('Creuset\Term', 'termable');
	}

	public function categories()
	{
		return $this->morphToMany('Creuset\Term', 'termable')
		->where('taxonomy', 'category');
	}

	public function tags()
	{
		return $this->morphToMany('Creuset\Term', 'termable')
		->where('taxonomy', 'tag');
	}

}
