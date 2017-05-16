<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * A Tag has many items.
     * @return [type] [description]
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
