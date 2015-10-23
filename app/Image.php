<?php

namespace Creuset;

use Creuset\Presenters\PresentableTrait;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image as Intervention;

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
        return \Config::get('filesystems.images_location');
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
