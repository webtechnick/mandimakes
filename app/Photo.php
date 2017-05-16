<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * A photo belongs to an item.
     * @return [type] [description]
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
