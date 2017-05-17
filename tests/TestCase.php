<?php

namespace Tests;

use App\Facades\Cart;
use App\Item;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function stripeData()
    {
        return $data = [
            "_token" => "7GPBuYfBYD8WdgNtkcWf36bM0rxcG5sITOnNTO1w",
            "shipping_id" => "1",
            "special_request" => null,
            "stripeToken" => "tok_1AKWUdEZtS6NC025iMJ3XphX",
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
        ];
    }

    public function buildCart()
    {
        $item = factory(Item::class)->create(['price_dollars' => '10']);
        $item2 = factory(Item::class)->create(['price_dollars' => '10']);

        Cart::addToCart($item);
        Cart::addToCart($item2, 2);
    }
}
