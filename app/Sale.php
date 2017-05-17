<?php

namespace App;

use App\Facades\Cart;
use App\Item;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['item_id','description','qty','price_dollars'];
    /**
     * Item belongs to Sale
     * @return [type] [description]
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Sale belongs to Order
     * @return [type] [description]
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Build a sales array based out of the current cart.
     * @return [type] [description]
     */
    public static function buildSalesFromCart()
    {
        $retval = [];
        foreach (Cart::get() as $key => $cart) {
            $retval[$key]['item_id'] = $cart->item->id;
            $retval[$key]['description'] = $cart->item->short_description;
            $retval[$key]['qty'] = $cart->qty;
            $retval[$key]['price_dollars'] = $cart->item->price() * $cart->qty;
        }
        return $retval;
    }
}
