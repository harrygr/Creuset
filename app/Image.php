<?php

namespace Creuset;

use Image as Intervention;
use Illuminate\Database\Eloquent\Model;
use Creuset\Presenters\PresentableTrait;

class Image extends Model
{
    use PresentableTrait;

    protected $presenter = 'Creuset\Presenters\ImagePresenter';

    protected $fillable = ['filename', 'path', 'thumbnail_path', 'user_id', 'title', 'caption'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('\Creuset\User', 'user_id', 'id');
    }

    /**
     * The default location to save images
     * @return string
     */
    public function baseDir()
    {
        return 'uploads/images';
    }

    /**
     * When setting the filename, also set the paths for the image
     * @param string
     */
    public function setFilenameAttribute($filename)
    {
        $this->attributes['filename'] = $filename;
        $this->attributes['path'] = $this->baseDir() . '/' . $filename;
        $this->attributes['thumbnail_path'] = $this->baseDir() . '/tn-' . $filename;
    }

    public function getFullPathAttribute()
    {
        return public_path($this->path);
    }

    public function getFullThumbnailPathAttribute()
    {
        return public_path($this->thumbnail_path);
    }

    /**
     * Generate a thumbnail and save on the filesystem
     * @return void
     */
    public function makeThumbnail()
    {
        Intervention::make(public_path($this->path))
            ->fit(200)
            ->save(public_path($this->thumbnail_path));
    }
}
