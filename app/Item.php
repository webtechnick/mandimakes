<?php

namespace App;

use App\CartItem;
use App\Events\ItemSaving;
use App\Order;
use App\Photo;
use App\Sale;
use App\Tag;
use App\Traits\Filterable;
use App\Traits\FormattedPrice;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Filterable, Taggable, FormattedPrice;

    public $fillable = ['title', 'description', 'title', 'price_dollars','qty','short_description','status'];

    protected $with = ['primaryPhoto'];

    public static $statuses = [
        '1' => 'Available',
        '0' => 'Unavailable',
        '2' => 'Sold',
    ];

    /**
     * Saving the
     * @var [type]
     */
    public $events = [
        'saving' => ItemSaving::class
    ];

    /**
     * Searchable filters
     * @return [type] [description]
     */
    protected function getFilters()
    {
        return [
            'title','description'
        ];
    }

    public function updateFromRequest($data)
    {
        $this->update($data);
        if (isset($data['tagString'])) {
            $this->syncTagString($data['tagString']);
        }
        return $this;
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
     * An item has many photos
     * @return [type] [description]
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get the primary photo for the item.
     * @return [type] [description]
     */
    public function primaryPhoto()
    {
        return $this->hasOne(Photo::class)->primary();
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
     * Add Photo to Item.
     * @param Photo $photo [description]
     */
    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }

    /**
     * [createFromRequest description]
     * @return [type] [description]
     */
    public static function createFromRequest($data)
    {
        $item = self::create($data);
        if (isset($data['tagString'])) {
            $item->syncTagString($data['tagString']);
        }
        return $item;
    }

    /**
     * Wrapper for clearTag
     * @return [type] [description]
     */
    public static function clearNew()
    {
        return Tag::clearByName('new');
    }

    /**
     * Boolean if item is instock
     * @return [type] [description]
     */
    public function inStock()
    {
        return ($this->isStatus('available') && $this->qty > 0);
    }

    /**
     * Shortcut wrapper for isStatus
     * @return boolean [description]
     */
    public function isAvailalbe()
    {
        return $this->isStatus('available');
    }

    /**
     * shortcut for available.
     * @param  [type]  $status [description]
     * @return boolean         [description]
     */
    public function isStatus($status)
    {
        return ($this->statusNice() == $this->formatStatus($status));
    }

    /**
     * Does the item have a primary photo?
     * @return boolean [description]
     */
    public function hasPrimaryPhoto()
    {
        return !! $this->primaryPhoto;
    }

    /**
     * Set the status on the item
     * @param [type] $status [description]
     */
    public function setStatus($status)
    {
        $statusId = $this->getStatusId($status);
        if ($statusId !== false) {
            $this->status = $statusId;
        }
        return $this;
    }

    /**
     * Format the incoming status to match statusNice
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function formatStatus($status)
    {
        return ucwords($status);
    }

    /**
     * Find the key of the incoming status string
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function getStatusId($status)
    {
        return array_search($this->formatStatus($status), self::$statuses);
    }

    /**
     * Get the nice status name
     * @return [type] [description]
     */
    public function statusNice()
    {
        return self::$statuses[$this->status];
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
     * Show URL for item
     * @return [type] [description]
     */
    public function url()
    {
        return route('items.show', $this);
    }

    /**
     * [adminUrl description]
     * @return [type] [description]
     */
    public function adminUrl()
    {
        return route('admin.items.edit', $this);
    }

    public function pic($size = 200)
    {
        if (!$this->hasPrimaryPhoto()) {
            return '';
        }
        return '<img src="'. $this->primaryPhoto->thumbnail($size) .'" class="img-rounded">';
    }

    /**
     * Get calculated price, with possible site discounts and such
     * @return [type] [description]
     */
    public function price()
    {
        return $this->price_dollars;
    }

    /**
     * Generate the short description from the description
     * @return [type] [description]
     */
    public function generateShortDescription()
    {
        if (!$this->short_description && !empty($this->description)) {
            $this->short_description = str_limit($this->description, 100);
        }
        return $this;
    }

    /**
     * Get related items
     * @param  int $count [description]
     * @return collection of related items
     */
    public function related($count = 6)
    {
        return self::byInputTags($this->tagSlugString)
                   ->where('id', '<>', $this->id)
                   ->inRandomOrder()
                   ->limit($count)
                   ->get();
    }

    /**
     * Reduce the item stock by qty passed in.
     * @param  [type] $qty [description]
     * @return [type]      [description]
     */
    public function reduceStock($qty = 1)
    {
        $newQty = $this->qty - $qty;
        if ($newQty < 0) {
            $newQty = 0;
        }
        $this->qty = $newQty;
        return $this->save();
    }

    /**
     * Increase the item stock
     * @param  integer $qty [description]
     * @return [type]       [description]
     */
    public function increaseStock($qty = 1)
    {
        $newQty = $this->qty + $qty;
        $this->qty = $newQty;
        return $this->save();
    }

    /**
     * Available scope
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get the current featured list of items.
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeFeatured($query)
    {
        $featured = config('app.featured') ?: 'new'; // TODO, customizable using Settings
        return $query->byInputTags($featured, true);
    }
}
