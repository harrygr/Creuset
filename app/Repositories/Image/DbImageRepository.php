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

    /**
     * Size in pixels of the image thumbnail
     * @var integer
     */
    private $thumbnailSize = 200;

    /**
     * The name of the image
     * @var string
     */
    private $imageName;

    /**
     * Create an image on the filesystem and corresponding database record
     * @param  UploadedFile $file The image to create
     * @return Image              The resultant image object
     */
    public function createFromForm(UploadedFile $file)
    {
        $name = $file->getClientOriginalName();
        
        $image = $this->saveAs($name);  

        $file->move(public_path($this->baseDir), $this->imageName);

        $this->makeThumbnail($image);
      
        return $image; 
    }

    /**
     * Persist an Image entity to the database
     * @param  string $name The name of the image
     * @return Image        The created Image
     */
    protected function saveAs($name)
    {

    $this->imageName = sprintf("%s_%s", time(), $name);

    return Image::create([
     'path'              => sprintf("%s/%s", $this->baseDir, $this->imageName),
     'thumbnail_path'    => sprintf("%s/%s-%s", $this->baseDir, $this->thumbnailSize, $this->imageName),
     ]);
    }

    /**
     * Generate a thumbail and save it in the filesystem
     * @param  Image  $image 
     * @return void
     */
    protected function makeThumbnail(Image $image)
    {
        Intervention::make(public_path($image->path))
            ->fit($this->thumbnailSize)
            ->save(public_path($image->thumbnail_path));
    }
}