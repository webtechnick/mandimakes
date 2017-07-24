<?php

namespace Tests;

use App\Facades\Cart;
use App\Item;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function stripeData($data = [])
    {
        return array_merge([
            "_token" => "7GPBuYfBYD8WdgNtkcWf36bM0rxcG5sITOnNTO1w",
            "shipping_id" => "1",
            "special_request" => null,
            //"stripeToken" => "tok_1AKWUdEZtS6NC025iMJ3XphX",
            "stripeToken" => "tok_visa",
            "stripeTokenType" => "card",
            "stripeEmail" => "nick@example.com",
            "stripeBillingName" => "Nick Baker",
            "stripeBillingAddressCountry" => "United States",
            "stripeBillingAddressCountryCode" => "US",
            "stripeBillingAddressZip" => "90210",
            "stripeBillingAddressLine1" => "123 Main Street",
            "stripeBillingAddressCity" => "Los Angeles",
            "stripeBillingAddressState" => "CA",
            "stripeShippingName" => "Nick Baker",
            "stripeShippingAddressCountry" => "United States",
            "stripeShippingAddressCountryCode" => "US",
            "stripeShippingAddressZip" => "90210",
            "stripeShippingAddressLine1" => "123 Main Street",
            "stripeShippingAddressCity" => "Los Angeles",
            "stripeShippingAddressState" => "CA",
        ], $data);
    }

    public function buildCart()
    {
        $item = factory(Item::class)->create(['price_dollars' => '10']);
        $item2 = factory(Item::class)->create(['price_dollars' => '10']);

        Cart::addToCart($item);
        Cart::addToCart($item2, 2);
    }

    /**
     * Make a factory model
     * @param  [type]  $model    [description]
     * @param  array   $defaults [description]
     * @param  integer $count    [description]
     * @return [type]            [description]
     */
    public function make($model, $defaults = [], $count = 1)
    {
        if ($count > 1) {
            return factory($model, $count)->make($defaults);
        }
        return factory($model)->make($defaults);
    }

    /**
     * Create a factory model
     * @param  [type]  $model    [description]
     * @param  array   $defaults [description]
     * @param  integer $count    [description]
     * @return [type]            [description]
     */
    public function create($model, $defaults = [], $count = 1)
    {
        if ($count > 1) {
            return factory($model, $count)->create($defaults);
        }
        return factory($model)->create($defaults);
    }

    /**
     * Sign in a user.
     * @param  boolean $is_admin [description]
     * @return [type]            [description]
     */
    public function signIn($user = null)
    {
        $user = $user ?: $this->create('App\User');
        $this->actingAs($user);
        return $user;
    }

    /**
     * Sign in an admin user.
     * @return [type] [description]
     */
    public function signInAdmin()
    {
        return $this->signIn($this->create('App\User', ['group' => 'admin']));
    }

    /**
     * Mock a class
     * @param  [type] $class [description]
     * @param  [type] $key   [description]
     * @return [type]        [description]
     */
    public function mock($class, $key = null)
    {
        $key = $key ?: $class;
        $mock = \Mockery::mock($class);
        app()->instance($key, $mock);
        return $mock;
    }
}
