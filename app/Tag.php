<?php

namespace App;

use App\Events\TagDeleting;
use App\Item;
use App\Traits\Filterable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable, Filterable;

    protected $fillable = [
        'name', 'slug'
    ];

    protected $events = [
        'deleting' => TagDeleting::class
    ];

    protected function getFilters()
    {
        return ['name','slug'];
    }

    /**
     * Slug source
     * @return [type] [description]
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /**
     * A Tag has many items.
     * @return [type] [description]
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    /**
     * Helper function to merge tag
     * @param  Tag    $from [description]
     * @return [type]       [description]
     */
    public function merge(Tag $from)
    {
        return Tag::mergeTags($this, $from);
    }

    /**
     * Merge two tags together.
     * @param  Tag    $to   [description]
     * @param  Tag    $from [description]
     * @return [type]       [description]
     */
    public static function mergeTags(Tag $to, Tag $from)
    {
        // Go through all items associated with From tag
        foreach ($from->items()->select('items.id')->get() as $item) {
            $item->removeTag($from);
            $item->removeTag($to); // Remove to, incase it's already there before we add
            $item->addTag($to);
        }
        // Delete the from tag.
        $from->delete();
        // Return the new merged tag
        return $to;
    }
}
