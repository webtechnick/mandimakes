<?php

namespace App;

use App\Address;
use App\Events\OrderDeleting;
use App\Facades\Cart;
use App\Sale;
use App\Shipping;
use App\Traits\Filterable;
use App\Traits\FormattedPrice;
use App\Traits\UtilityScopes;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use UtilityScopes, FormattedPrice, Filterable;

    protected $fillable = ['shipping_id','special_request','email','phone','stripeToken','tracking_number'];

    protected $with = ['sales'];

    protected $events = [
        'deleting' => OrderDeleting::class
    ];

    protected static $statuses = [
        0 => 'pending',
        1 => 'success',
        2 => 'decline',
        3 => 'error',
        4 => 'shipped',
    ];

    public $casts = [
        'is_approved' => 'boolean'
    ];

    public function getFilters()
    {
        return ['email','phone','id'];
    }

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

    public function price()
    {
        return $this->total_dollars;
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
     * New orders scope
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeUnseen($query)
    {
        return $query->where('is_new', 1);
    }

    /**
     * Unseen order count
     * @return [type] [description]
     */
    public static function unseenCount()
    {
        return self::unseen()->select(['id'])->count();
    }

    public function statusNice()
    {
        return ucwords(self::$statuses[$this->status]);
    }

    public function adminUrl()
    {
        return route('admin.orders.edit', $this);
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
        // Login the user
        Auth::login($user);

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
        $subtotal = Cart::subTotal();
        $this->tax_dollars = 0;
        $this->discount_dollars = 0;
        $this->shipping_price_dollars = 0;
        if ($this->shipping) {
            $this->shipping_price_dollars = $this->shipping->price_dollars;
        }

        // Total the order
        $this->total_dollars = $subtotal + $this->tax_dollars + $this->shipping_dollars - $this->discount_dollars;
        return $this;
    }

    /**
     * Create an order based on stripe input data.
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public static function createFromStripe($data)
    {
        $order = new self($data);

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
        $order->calcuateTotalDollars()->save();

        return $order;
    }

    public function markOutcome($outcome = null)
    {
        if ($outcome) {
            $this->stripeOutcome = $outcome;
        }
        return $this;
    }

    /**
     * Mark the order as success.
     * @return [type] [description]
     */
    public function markSuccess($outcome = null)
    {
        $this->markOutcome($outcome);
        $this->status = 1;
        $this->is_approved = true;
        return $this;
    }

    /**
     * Mark the order as declined.
     * @return [type] [description]
     */
    public function markDecline($outcome = null)
    {
        $this->markOutcome($outcome);
        $this->status = 2;
        $this->is_approved = false;
        return $this;
    }

    /**
     * Mark the order as error.
     * @return [type] [description]
     */
    public function markError($outcome = null)
    {
        $this->markOutcome($outcome);
        $this->status = 3;
        $this->is_approved = false;
        return $this;
    }

    /**
     * Charge the order to stripe
     * @return [type] [description]
     */
    public function charge()
    {
        $key = config('services.stripe.secret');
        \Stripe\Stripe::setApiKey($key);

        // Figure out the stripe ID, if we have one already
        // Or if we need to create a new customer
        /*$stripe_id = null;
        if (Auth::check() && Auth::user()->stripe_id) {
            $stripe_id = Auth::user()->stripe_id;
        } else {
            // Create a Customer:
            $customer = \Stripe\Customer::create([
                "email" => $this->email,
                "source" => $this->stripeToken,
            ]);

            $stripe_id = $customer->id;
        }

        // Store stripe customer into users table.
        if (Auth::check()) {
            Auth::user()->saveStripeId($stripe_id);
        }
        */
        // Actually charge the card.
        try {
            $charge = \Stripe\Charge::create([
                "amount" => $this->total_dollars * 100,
                "currency" => "usd",
                //"customer" => $stripe_id,
                "source" => $this->stripeToken,
                "metadata" => [
                    "order_id" => $this->id,
                ]
            ]);

            $this->markSuccess($charge->outcome->__toJSON());
            //$this->stripeCharge = $charge->id;

        } catch(\Stripe\Error\Card $e) { // Card Declined.
            $this->markDecline($e->getMessage());
            //$this->stripeCharge = $e->jsonBody['error']['charge'];
        } catch (\Stripe\Error\Base $e) { // Card Error
            $this->markError($e->getMessage());
        }

        $this->save();

        return $this;
    }

    /**
     * Return if order is good.
     * @return boolean [description]
     */
    public function isGood()
    {
        return $this->is_approved == 1;
    }

    /**
     * Return if the order has a tracking information associated to it.
     * @return boolean [description]
     */
    public function hasTracking()
    {
        return !!$this->tracking_number;
    }

    /**
     * Return the tracking URL
     * @return [type] [description]
     */
    public function trackingUrl()
    {
        if (!$this->hasTracking()) {
            return null;
        }
        return 'https://tools.usps.com/go/TrackConfirmAction.action?tLabels=' . $this->tracking_number;
    }

    /**
     * Decide what mailings should be sent out.
     * @return [type] [description]
     */
    public function notify()
    {

    }
}
