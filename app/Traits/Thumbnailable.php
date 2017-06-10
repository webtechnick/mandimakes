<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait Thumbnailable
{
    /**
     * Will return a path to the thumbnail at given size
     * if size is not present, create it, store it, then return path.
     * @param  integer $width [description]
     * @return [type]         [description]
     */
    public function thumbnail($size = null)
    {
        $size = $this->getSize($size);
        if (!$this->thumbnailExists($size)) {
            $this->createThumbnail($size);
        }
        return Storage::disk(config('thumbnail.disk'))->url($this->thumbnailFileName($size));
    }

    /**
     * Determine if the thumbnail exists.
     * @param  integer $size [description]
     * @return [type]        [description]
     */
    public function thumbnailExists($size = null)
    {
        $size = $this->getSize($size);
        return Storage::disk(config('thumbnail.disk'))
                        ->exists($this->thumbnailFileName($size));
    }

    /**
     * Give me the full path to save the thumbnail to.
     * @param  integer $size [description]
     * @return [type]        [description]
     */
    public function thumbnailPath()
    {
        return config('filesystems.disks.'. config('thumbnail.disk') .'.root');
    }

    /**
     * Get the calculated thumbnail path.
     * @param  integer $size [description]
     * @return [type]        [description]
     */
    public function thumbnailFileName($size = null)
    {
        $size = $this->getSize($size);
        return $size . 'x' . $this->getFileName();
    }

    /**
     * Create the thumbnail using the Image library
     * @param  integer $size [description]
     * @return [type]        [description]
     */
    private function createThumbnail($size = null)
    {
        $img = Storage::disk(config('thumbnail.disk'))->get($this->getFileName());
        $size = $this->getSize($size);

        Image::make($img)
              ->fit($size)
              ->save($this->thumbnailPath() . '/' . $this->thumbnailFileName($size));
    }

    /**
     * Get the size
     * @param  [type] $size [description]
     * @return [type]       [description]
     */
    private function getSize($size)
    {
        return $size ?: config('thumbnail.size');
    }

    /**
     * Get the filename of the file
     * @return [type] [description]
     */
    private function getFileName()
    {
        $name_field = config('thumbnail.name_field');
        return $this->$name_field;
    }
}