<?php

namespace App;

use App\CartItem;
use App\Order;
use App\Photo;
use App\Sale;
use App\Tag;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Filterable;

    protected function getFilters()
    {
        return [
            'title','description'
        ];
    }
    /**
     * An item has many sales
     * @return [type] [description]
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * An item has many orders through sales.
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Sale::class);
    }

    /**
     * An item has and belongs to many tags.
     * @return [type] [description]
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * An item has many photos
     * @return [type] [description]
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * An item can have many carts.
     * @return [type] [description]
     */
    public function carts()
    {
        return $this->hasMany(CartItem::class);
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
     * Increment the cart_count
     * @return [type] [description]
     */
    public function incrimentCart()
    {
        $this->cart_count++;
        $this->save();
        // TODO save a CartItem if logged in user.
        return $this;
    }

    /**
     * Takes in a tags CSV string of slugs
     * @param  [type] $query [description]
     * @param  [type] $tags  [description]
     * @return [type]        [description]
     */
    public function scopeByInputTags($query, $tagstring = null)
    {
        $tagstring = trim($tagstring);
        $tagstring = str_replace(' ', '', $tagstring);
        $tags = explode(',', $tagstring);
        if (count($tags)) {
            return $query->byTags($tags);
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

    /**
     * Price of item, formatted.
     * @return [type] [description]
     */
    public function formattedPrice()
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        return money_format('%.2n', $this->price());
    }

    /**
     * Get calculated price, with possible site discounts and such
     * @return [type] [description]
     */
    public function price()
    {
        return $this->price_dollars;
    }
}
