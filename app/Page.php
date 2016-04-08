<?php

namespace App;

use App\Traits\Postable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Presenters\PresentableTrait;

class Page extends Model
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
}
