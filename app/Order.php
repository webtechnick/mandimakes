<?php

namespace App;

use App\Address;
use App\Shipping;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * An order belongs to a user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has a billing address
     * @return [type] [description]
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Order has a shipping address
     * @return [type] [description]
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * An order belongs to a
     * @return [type] [description]
     */
    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    /**
     * Mark an order as seen.
     * @return [type] [description]
     */
    public function seen()
    {
        $this->is_new = false;
        return $this;
    }
}
