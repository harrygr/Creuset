<?php

namespace Creuset;

use Spatie\MediaLibrary\Media as BaseMedia;

class Media extends BaseMedia 
{
    /**
     * The attributes to include in json responses and toArray calls
     * @var Array
     */
    protected $appends = ['url', 'thumbnail_url'];

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getUrl('thumb');
    }
}