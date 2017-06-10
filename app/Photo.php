<?php

namespace App;

use App\Events\PhotoDeleting;
use App\Events\PhotoSaving;
use App\Item;
use App\Libs\Thumbnail;
use App\Traits\Thumbnailable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Photo extends Model
{
    use Thumbnailable;

    protected $fillable = ['name', 'thumbnail_path', 'path'];

    protected $events = [
        'saving' => PhotoSaving::class,
        'deleting' => PhotoDeleting::class,
    ];

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
    }

    /**
     * Construct a photo from an uploaded file.
     *
     * @param  UploadedFile $file [description]
     * @return [type]             [description]
     */
    public static function fromUploadedFile(UploadedFile $file)
    {
        // Start photo
        $photo = (new self)->saveAs($file->getClientOriginalName());
        // Move uploaded photo to directory
        $file->move($photo->baseDir(), $photo->name);
        // Eager create a thumbnail for ourselves
        $photo->thumbnail(200);

        return $photo;
    }

    /**
     * Base directory path relative to /public
     * @return String path relative to public directory
     */
    public function baseDir()
    {
        return 'uploads/photos/';
    }

    /**
     * Scope for primary photo
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', 1);
    }

    /**
     * Check if photo is the primary photo
     * @return boolean [description]
     */
    public function isPrimary()
    {
        return $this->is_primary == 1;
    }

    /**
     * Clear all primary photos from the associated item
     * @return [type] [description]
     */
    public function clearPrimary()
    {
        return self::where('item_id', $this->item_id)->primary()->update(['is_primary' => 0]);
    }

    /**
     * make this photo the primary photo
     * @return [type] [description]
     */
    public function makePrimary()
    {
        $this->clearPrimary();
        $this->is_primary = 1;
        return $this;
    }
}
