<?php

namespace App;

use App\Item;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'item_id'];

    /**
     * A cart item belongs to an item
     * @return [type] [description]
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * A cart item belongs to a user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
