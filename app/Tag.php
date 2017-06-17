<?php

namespace App;

use App\Events\TagDeleting;
use App\Item;
use App\Traits\Filterable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        return self::mergeTags($this, $from);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->orWhere('slug', $name);
    }

    public static function findBySlugOrName($name)
    {
        return self::byName($name)->first();
    }

    /**
     * Clear the tag from all items.
     * @return [type] [description]
     */
    public function clear()
    {
        $this->items()->detach();
        return $this;
    }

    /**
     * Return full list of popular tags for the nav
     * Future itterations should cache this result
     * @return collection of tags
     */
    public static function allForNav()
    {
        return Cache::remember('tags_nav', 60, function () {
            return self::select(['name','slug'])
                    ->orderBy('name', 'asc')
                    ->limit(20)
                    ->get();
        });
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
