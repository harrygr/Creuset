<?php

namespace App;

use App\Presenters\PresentableTrait;
use App\Traits\Postable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends \Baum\Node
{
    use Postable, SoftDeletes, PresentableTrait;

    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'content', 'user_id', 'post_id', 'type', 'status', 'published_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'published_at', 'deleted_at'];

    protected $presenter = 'App\Presenters\PostPresenter';

    /**
     * Get the full url path to the page, based on its page hierarchy.
     *
     * @param bool $excludeSelf exclude the slug of the current page.
     *
     * @return string
     */
    public function getPath($excludeSelf = false)
    {
        return '/'.$this->ancestors()
                          ->pluck('slug')
                          ->merge($excludeSelf ? [] : [$this->slug])
                          ->implode('/');
    }
}
