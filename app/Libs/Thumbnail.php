<?php

namespace App\Libs;

use Intervention\Image\Facades\Image;

/**
 * Build a thumbnail from a path using the Image facade
 */
class Thumbnail
{

    protected $path;
    protected $thumbnail_path;
    protected $size;

    /**
     * Constructor
     * @param String  $path           relative to /public
     * @param String  $thumbnail_path relative to /public
     * @param integer $size           default 200 squre
     */
    public function __construct($path, $thumbnail_path, $size = 200)
    {
        $this->path = $path;
        $this->thumbnail_path = $thumbnail_path;
        $this->size = $size;
    }

    /**
     * Create and save the thumbnail
     * @return self
     */
    public function save()
    {
        Image::make($this->path)
              ->fit($this->size)
              ->save($this->thumbnail_path);

        return $this;
    }
}
