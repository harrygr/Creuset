<?php

namespace App;

use Spatie\MediaLibrary\Media as BaseMedia;

class Media extends BaseMedia
{
    //protected $guarded = ['id', 'disk', 'file_name', 'size', 'model_type', 'model_id'];
    protected $fillable = ['custom_properties', 'collection_name', 'name', 'order_column', 'size', 'manipulations'];
    /**
     * The attributes to include in json responses and toArray calls.
     *
     * @var array
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
