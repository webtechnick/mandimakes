<?php

namespace App;

use App\Item;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
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
}
