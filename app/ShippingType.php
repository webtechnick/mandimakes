<?php

namespace App;

use App\Shipping;
use Illuminate\Database\Eloquent\Model;

class ShippingType extends Model
{
    /**
     * A shipping type (UPS, USPS) has many shippings (next day air, etc..)
     * @return [type] [description]
     */
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
}
