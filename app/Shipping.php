<?php

namespace App;

use App\ShippingType;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /**
     * What type of shipping is it, (USPS), (UPS)
     * @return [type] [description]
     */
    public function type()
    {
        return $this->belongsTo(ShippingType::class, 'shipping_type_id');
    }
}
