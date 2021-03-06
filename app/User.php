<?php

namespace App;

use App\CartItem;
use App\Order;
use App\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Retrieve cart for user
     * @return [type] [description]
     */
    public function carts()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * A user has many orders
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * A user has many posts.
     * @return [type] [description]
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Is the user an admin?
     * @return boolean [description]
     */
    public function isAdmin()
    {
        return $this->group == 'admin';
    }

    /**
     * Set the user as admin.
     */
    public function setAdmin()
    {
        $this->group = 'admin';
        return $this;
    }

    /**
     * Set the user as user.
     */
    public function setUser()
    {
        $this->group = 'user';
        return $this;
    }

    /**
     * Save the stripe ID to the user.
     * @param  [type] $stripe_id [description]
     * @return [type]            [description]
     */
    public function saveStripeId($stripe_id)
    {
        $this->stripe_id = $stripe_id;
        $this->save();
        return $this;
    }

    /**
     * Create a new user from stripe data
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function createFromStripe($data)
    {
        $user = new self($data);
        $user->password = bcrypt('secret');
        $user->save();
        return $user;
    }
}
