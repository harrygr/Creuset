<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;
use Creuset\Presenters\PresentableTrait;

class Image extends Model
{
    use PresentableTrait;

    protected $presenter = 'Creuset\Presenters\ImagePresenter';

    protected $fillable = ['path', 'thumbnail_path', 'user_id', 'title', 'caption'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('\Creuset\User', 'user_id', 'id');
    }
}
