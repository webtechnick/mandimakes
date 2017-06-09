<?php

namespace App;

use App\CartItem;
use App\Events\ItemSaving;
use App\Order;
use App\Photo;
use App\Sale;
use App\Tag;
use App\Traits\Filterable;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Filterable, Taggable;

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

    public function url()
    {
        return route('items.show', $this);
    }

    public function adminUrl()
    {
        return route('admin.items.edit', $this);
    }

    public function pic($size = 200)
    {
        if (!$this->hasPrimaryPhoto()) {
            return '';
        }
        return '<img src="/'. $this->primaryPhoto->thumbnail_path .'" class="img-rounded" width="'. $size .'">';
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

    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }
}
