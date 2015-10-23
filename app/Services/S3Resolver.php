<?php

namespace Creuset\Services;

use Illuminate\Contracts\Filesystem\Filesystem;

class S3Resolver {
    private $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: app(Filesystem::class);
    }
    
    public function url($path)
    {
        return $this->filesystem
            ->getAdapter()
            ->getClient()
            ->getObjectUrl(\Config::get('filesystems.disks.s3.bucket'), $path);
    }
}