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
        'name', 'slug', 'is_nav'
    ];

    protected $casts = [
        'is_nav' => 'boolean',
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

    /**
     * Scope for finding tag by name or slug
     * @param  [type] $query [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->orWhere('slug', $name);
    }

    /**
     * Find the tag by slug or name
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
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
     * Static call to clear a tag from all related items.
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function clearByName($name)
    {
        $tag = self::findBySlugOrName($name);
        if (!$tag) {
            Log::error('Tag: ' . $name . ' not found.');
            return false;
        }
        $tag->clear();
        return true;
    }

    /**
     * Return full list of popular tags for the nav
     * Future itterations should cache this result
     * @return collection of tags
     */
    public static function allForNav($limit = 12)
    {
        return Cache::remember("tags_nav_$limit", 60, function () use ($limit) {
            return self::select(['name','slug'])
                    ->where('is_nav', true)
                    ->orderBy('name', 'asc')
                    ->limit($limit)
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
