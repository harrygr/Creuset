<?php 

namespace Creuset\Repositories\Image;

use Creuset\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DbImageRepository implements ImageRepository {

    /**
     * The default location to save images
     * @var string
     */
    private $baseDir = 'uploads/images';

    public function createFromForm(UploadedFile $file)
    {
        $name = time() . $file->getClientOriginalName();

        $saveDir = $this->baseDir;

        $file->move(public_path($saveDir), $name);

        return Image::create([
            'path'              => "$saveDir/{$name}",
            'thumbnail_path'    => "$saveDir/{$name}",
            ]);
    }
}