<?php

namespace App;

use App\Item;
use App\Libs\Thumbnail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Photo extends Model
{
    protected $fillable = ['name', 'thumbnail_path', 'path'];

    /**
     * A photo belongs to an item.
     * @return [type] [description]
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

   /**
     * filling the fields based on a passined in filename
     *
     * @param  String filename
     * @return self
     */
    public function saveAs($filename)
    {
        $this->name = time() . '-' . $filename;
        return $this;
    }

    /**
     * Mutator, if name changes, also updated path and thumbnail_path
     *
     * @param string name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->path = $this->baseDir() . $name;
        $this->thumbnail_path = $this->baseDir() . 'tn-' . $name;
    }

    /**
     * Constructor building uploaded file
     *
     * @param  UploadedFile $file [description]
     * @return self
     */
    public static function fromFileUpload(UploadedFile $file)
    {
        // Build the photo
        $photo = (new static)->saveAs($file->getClientOriginalName());
        // Move the uploaded file
        $file->move($photo->baseDir(), $photo->name);
        // Make a thumbnail
        $photo->makeThumbnail();

        return $photo;
    }

    /**
     * Make the thumbnail out of the photo
     *
     * @return [type] [description]
     */
    public function makeThumbnail($size = 200)
    {
        (new Thumbnail($this->path, $this->thumbnail_path, $size))->save();

        return $this;
    }

    /**
     * Base directory path relative to /public
     * @return String path relative to public directory
     */
    public function baseDir()
    {
        return 'uploads/photos/';
    }
}
