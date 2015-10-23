<?php

namespace Creuset;

use Creuset\Presenters\PresentableTrait;
use Creuset\Services\S3Resolver;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image as Intervention;

class Image extends Model
{
    use PresentableTrait;

    protected $presenter = 'Creuset\Presenters\ImagePresenter';

    /**
     * The attributes that are mass-assignable
     * @var Array
     */
    protected $fillable = ['filename', 'path', 'thumbnail_path', 'user_id', 'title', 'caption'];

    /**
     * The attributes to include in json responses and toArray calls
     * @var Array
     */
    protected $appends = ['url', 'thumbnail_url'];

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
        return \Config::get('filesystems.images_location');
    }

    /**
     * Get the full URL to the image
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * Get the full URL to the thumbnail
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->url(1);
    }

    /**
     * Compute the URL of the image
     * @param  boolean $thumbnail Should it return the thumbnail
     * @return string
     */
    public function url($thumbnail = false)
    {
        $path = $thumbnail ? $this->thumbnail_path : $this->path;

        if (\Config::get('filesystems.default') == 's3') {
            return (new S3Resolver)->url($path);
        }

        return url($path); // Local storage location must be public path
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

    /**
     * Delete the image's files from storage
     */
    public function deleteFiles()
    {
        $filesystem = app(Filesystem::class);

        if ($filesystem->exists($this->path)) {
            $filesystem->delete($this->path);            
        }
        if ($filesystem->exists($this->thumbnail_path)) {
            $filesystem->delete($this->thumbnail_path);
        }
    }
}
