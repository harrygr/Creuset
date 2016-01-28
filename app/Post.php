<?php

namespace Creuset;

use Carbon\Carbon;
use Creuset\Contracts\Termable;
use Creuset\Presenters\PresentableTrait;
use Creuset\Traits\HasTerms;
use Creuset\Traits\Postable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Post extends Model implements HasMediaConversions, Termable
{
    use PresentableTrait, SoftDeletes, HasTerms, HasMediaTrait, Postable;

    /**
     * Set the image sizes for post attachments.
     * 
     * @return void
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
             ->setManipulations(['w' => 300, 'h' => 300])
             ->performOnCollections('images');
    }

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
        'published'    => 'Published',
        'draft'        => 'Draft',
        'private'      => 'Private',
    ];

    /**
     * Parses a date string into a Carbon instance for saving.
     * 
     * This shouldn't really need to be done, but Laravel's automatic date
     * mutators expects strings to be in the format Y-m-d H-i-s which is 
     * not always the case; such as for 'datetime-local' html5 fields
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
     * If the post doesn't have a user ID set we'll return the ID of the logged in user.
     *
     * @param int $userId
     *
     * @return int
     */
    public function getUserIdAttribute($userId)
    {
        return $userId ?: \Auth::user()->id;
    }

    // Relations

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

    /**
     * Whether the post is not yet persisted.
     *
     * @return bool
     */
    public function isNew()
    {
        return !$this->exists();
    }

    /**
     * Whether the post exists in the database yet.
     *
     * @return bool
     */
    public function exists()
    {
        return $this->id;
    }

    /**
     * The field to use to display the parent name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->title;
    }
}
