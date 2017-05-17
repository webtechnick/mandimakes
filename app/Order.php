<?php

namespace App;

use App\Address;
use App\Facades\Cart;
use App\Sale;
use App\Shipping;
use App\Traits\UtilityScopes;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use UtilityScopes;

    protected $fillable = ['shipping_id','special_request','email','phone', 'stripeToken'];

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
     * An order has many sales
     * @return [type] [description]
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * My orders scope
     * @param  Builder $query [description]
     * @return [type]         [description]
     */
    public function scopeMyOrders($query)
    {
        return $query->where('user_id', '=', Auth::user()->id);
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

    /**
     * is the order new?
     * @return boolean [description]
     */
    public function isNew()
    {
        return !!$this->is_new;
    }

    /**
     * [setUserIdFromEmail description]
     * @param [type] $email [description]
     */
    public function setUserIdFromStripe($data)
    {
        $email = $data['stripeEmail'];
        $name = $data['stripeBillingName'];

        $user = User::select('id')->where('email', '=', $email)->first();
        if (!$user) {
            // User not found, create user.
            $user = User::createFromStripe(['name' => $name, 'email' => $email]);
        }

        $this->user()->associate($user);
        return $this;
    }

    /**
     * Go through the cart, and figure out the total dollars
     * Adding shipping cost, tax (if needed), and subtracting discount
     * @return [type] [description]
     */
    public function calcuateTotalDollars()
    {
        $this->total_dollars = Cart::subTotal();
        return $this;
    }

    /**
     * Create an order based on stripe input data.
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public static function createFromStripe($data)
    {
        $order = new Order($data);

        // Assign the email
        $order->email = $data['stripeEmail'];

        // retrieve user_id from Auth or Create/Lookup account via email.
        if (Auth::check()) {
            $order->user()->associate(Auth::user());
        } else {
            $order->setUserIdFromStripe($data);
        }

        // Assign billing and shipping addresses
        $billing = Address::createFromStripe($data, 'billing');
        $order->billingAddress()->associate($billing);

        $shipping = Address::createFromStripe($data, 'shipping');
        $order->shippingAddress()->associate($shipping);

        // Save the order
        $order->save();

        // Add Sales to Order
        // $order->sales()->createMany($data['sales']);
        $order->sales()->createMany(Sale::buildSalesFromCart());

        // Calculate the total_dollars
        $order->calcuateTotalDollars();

        return $order;
    }

    /**
     * Charge the order
     * @return [type] [description]
     */
    public function charge()
    {

    }
}
