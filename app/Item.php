<?php

namespace App;

use App\CartItem;
use App\Order;
use App\Photo;
use App\Sale;
use App\Tag;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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
