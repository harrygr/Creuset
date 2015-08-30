<?php

namespace Creuset;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path', 'thumbnail_path'];

    public function post()
    {
        return $this->belongsTo('\Creuset\Post');
    }
}
