<?php

namespace Creuset;

use Creuset\Image;

interface Imageable {

	/**
	 * An entity has many images
	 * @return Relation
	 */
	public function images();

	/**
	 * Attach an image to the current Entity
	 * @param Image $image
	 */
	public function addImage(Image $image);
}