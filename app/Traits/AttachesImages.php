<?php

namespace Creuset\Traits;

use Creuset\Image;

trait AttachesImages {
	/**
	 * A post has many images
	 * @return Relation
	 */
	public function images()
	{
		return $this->morphMany(Image::class, 'imageable');
	}

	public function image()
	{
		return $this->belongsTo(Image::class);
	}

	/**
	 * Attach an image to the current Post
	 * @param Image $image
	 */
	public function addImage(Image $image)
	{
		return $this->images()->save($image);
	}

	/**
	 * The field to use to display the parent name
	 * @return string
	 */
	public function getImageableField()
	{
		return 'title';
	}

}
