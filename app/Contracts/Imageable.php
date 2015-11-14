<?php

namespace Creuset\Contracts;

use Creuset\Image;

/**
 * This is the contract for enabling the attaching of images to 
 * a model. The Creuset\Traits\AttachedImages trait can be 
 * used to get an implentation of the below.
 */
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

	/**
	 * The field to use to display the parent name
	 * @return string
	 */
	public function getImageableField();

}