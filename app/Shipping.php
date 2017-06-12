<?php

namespace App;

use App\ShippingType;
use App\Traits\Filterable;
use App\Traits\FormattedPrice;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use FormattedPrice, Filterable;

    protected $with = ['type'];

    protected $fillable = ['name','price_dollars', 'shipping_type_id'];
    /**
     * What type of shipping is it, (USPS), (UPS)
     * @return [type] [description]
     */
    public function type()
    {
        return $this->belongsTo(ShippingType::class, 'shipping_type_id');
    }

    public function getFilters()
    {
        return ['name'];
    }

    /**
     * Layer of abstraction in case it changes by user
     * @return [type] [description]
     */
    public function price()
    {
        return $this->price_dollars;
    }

    public function adminUrl()
    {
        return route('admin.shippings.edit', $this);
    }
}
