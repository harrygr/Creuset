<?php 

namespace Creuset\Repositories\Image;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageRepository {   
    public function createFromForm(UploadedFile $file);
}