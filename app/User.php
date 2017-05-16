<?php

namespace App;

use App\CartItem;
use App\Order;
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
        'name', 'email', 'password',
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
}
