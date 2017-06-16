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

    /**
     * Get the filters for a shipping search
     * @return [type] [description]
     */
    public function getFilters()
    {
        return ['name'];
    }

    /**
     * Get the list of items.
     * @return [type] [description]
     */
    public static function listOptions()
    {
        $shippings = self::forList()->get();
        $retval = [];
        foreach ($shippings as $shipping) {
            $retval[$shipping->id] = "{$shipping->type->name} {$shipping->name} ({$shipping->formattedPrice()})";
        }
        return $retval;
    }

    /**
     * Scope for list
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeForList($query)
    {
        return $query->select(['id','shipping_type_id','name','price_dollars'])
                     ->orderBy('price_dollars', 'ASC');
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
