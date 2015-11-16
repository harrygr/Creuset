<?php

namespace Creuset\Services;

use Illuminate\Contracts\Filesystem\Filesystem;

class S3Resolver {
    private $filesystem;

    /**
     * Create a new S3 Resolver instance
     * @param Filesystem|null $filesystem The filesystem implementation
     */
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: app(Filesystem::class);
    }
    
    /**
     * Get the url of a file stored in S3
     * @param  string $path The path of the file as it exists in S3
     * @return string       The public URL to the file
     */
    public function url($path)
    {
        return $this->filesystem
            ->getAdapter()
            ->getClient()
            ->getObjectUrl(\Config::get('filesystems.disks.s3.bucket'), $path);
    }
}