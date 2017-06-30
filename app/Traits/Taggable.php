<?php

namespace App\Traits;

use App\Tag;
use Illuminate\Support\Facades\Log;

trait Taggable
{
    /**
     * An item has and belongs to many tags.
     * @return [type] [description]
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Attach a tag to an item.
     * @param Tag $tag [description]
     */
    public function addTag(Tag $tag)
    {
        return $this->tags()->attach($tag);
    }

    /**
     * Find or create tag based on csv list
     * @param  [type] $mixed [description]
     * @return [type]        [description]
     */
    public function syncTagString($string)
    {
        $this->tags()->detach(); // clear tags.

        $tags = explode(',', $string);
        foreach($tags as $name) {
            $name = trim($name);
            $tag = Tag::where('name', $name)->orWhere('slug', $name)->first();
            if (!$tag) {
                $tag = Tag::create(['name' => $name]);
            }
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * Set the tagString will associate tags to the item, creating what we need
     * @param [type] $value [description]
     */
    public function setTagStringAttribute($value)
    {
        return $this->syncTagString($value);
    }

    /**
     * tagString as CSV
     * @return [type] [description]
     */
    public function getTagStringAttribute()
    {
        return $this->tags()->pluck('name')->implode(',');
    }

    /**
     * TagString as slugs for use with byInputTags
     * @return [type] [description]
     */
    public function getTagSlugStringAttribute()
    {
        return $this->tags()->pluck('slug')->implode(',');
    }

    /**
     * Attach more than one tag
     * @param [array] $tags [description]
     */
    public function addTags($tags)
    {
        return $this->tags()->attach($tags);
    }

    /**
     * Sync the tags passed into the model
     * @param  [type] $tags [description]
     * @return [type]       [description]
     */
    public function syncTags($tags)
    {
        return $this->tags()->sync($tags);
    }

    /**
     * Remove Tag from model.
     * @param  Tag    $tag [description]
     * @return [type]      [description]
     */
    public function removeTag(Tag $tag)
    {
        return $this->tags()->detach($tag);
    }

    /**
     * Takes in a tags CSV string of slugs
     * @param  [type] $query [description]
     * @param  [type] $tags  [description]
     * @return [type]        [description]
     */
    public function scopeByInputTags($query, $tagstring = null, $matchAll = false)
    {
        $tagstring = trim($tagstring);
        $tagstring = str_replace(' ', '', $tagstring);
        $tags = explode(',', $tagstring);
        if (count($tags)) {
            return $query->byTags($tags, $matchAll);
        }
        return $query;
    }

    /**
     * Scope find items by tags, takes in an array of tag slugs
     * as well as a boolean matchAll (default false)
     * @param  [type]  $query    passed in automatically
     * @param  array   $tags     [description]
     * @param  boolean $matchAll [if true, will restrict to items with all tags attached to it]
     * @return [type]            [description]
     */
    public function scopeByTags($query, $tags = [], $matchAll = false)
    {
        if (!$matchAll) {
            // Find all with any tag given
            $query->whereHas('tags', function($query) use($tags) {
                $query->whereIn('slug', $tags);
            });
        } else {
            // Find all with exactly tags given
            $query->whereHas('tags', function($query) use($tags) {
                $query->whereIn('slug', $tags);
            }, '=', count($tags));
        }
        return $query;
    }
}