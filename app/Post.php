<?php

namespace App;

use App\Contracts\Termable;
use App\Presenters\PresentableTrait;
use App\Traits\HasTerms;
use App\Traits\Postable;
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

    protected $presenter = 'App\Presenters\PostPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
    protected $fillable = ['title', 'slug', 'content', 'user_id', 'post_id', 'type', 'status', 'published_at'];

    public static $postStatuses = [
        'published'    => 'Published',
        'draft'        => 'Draft',
        'private'      => 'Private',
    ];

    /**
     * Sync an array of terms to the post.
     *
     * @param arra $terms
     *
     * @return Post
     */
    public function syncTerms(array $terms = [])
    {
        $this->terms()->sync($terms);

        return $this;
    }
}
