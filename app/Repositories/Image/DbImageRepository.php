<?php 

namespace Creuset\Repositories\Image;

use Creuset\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Image as Intervention;

class DbImageRepository implements ImageRepository {

    /**
     * The default location to save images
     * @var string
     */
    private $baseDir = 'uploads/images';

    private $thumbnailSize = 200;

    private $imageName;

    public function createFromForm(UploadedFile $file)
    {
        $name = $file->getClientOriginalName();
        
        $image = $this->saveAs($name);  

        $file->move(public_path($this->baseDir), $this->imageName);

        $this->makeThumbnail($image);
      
        return $image; 
    }

    protected function saveAs($name)
    {

    $this->imageName = sprintf("%s_%s", time(), $name);

    return Image::create([
     'path'              => sprintf("%s/%s", $this->baseDir, $this->imageName),
     'thumbnail_path'    => sprintf("%s/%s-%s", $this->baseDir, $this->thumbnailSize, $this->imageName),
     ]);
    }

    protected function makeThumbnail(Image $image)
    {
        Intervention::make(public_path($image->path))
            ->fit($this->thumbnailSize)
            ->save(public_path($image->thumbnail_path));
    }
}