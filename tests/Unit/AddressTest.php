<?php

namespace Tests\Unit;

use App\Address;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_create_new_billing_address_from_stripe()
    {
        $data = $this->stripeData();

        $address = Address::createFromStripe($data, 'billing');

        $this->assertEquals('Nick Baker', $address->name_line);
        $this->assertEquals('90210', $address->zipcode);
        $this->assertEquals('123 Main Street', $address->street);
        $this->assertEquals('', $address->street_2);
        $this->assertEquals('Los Angeles', $address->city);
        $this->assertEquals('CA', $address->state);
        $this->assertEquals('US', $address->country);
    }

    /** @test */
    public function it_should_create_new_shipping_address_from_stripe()
    {
        $data = $this->stripeData();

        $address = Address::createFromStripe($data, 'shipping');

        $this->assertEquals('Nick Baker', $address->name_line);
        $this->assertEquals('90210', $address->zipcode);
        $this->assertEquals('123 Main Street', $address->street);
        $this->assertEquals('', $address->street_2);
        $this->assertEquals('Los Angeles', $address->city);
        $this->assertEquals('CA', $address->state);
        $this->assertEquals('US', $address->country);
    }

    /** @test */
    public function it_should_not_create_duplicate_addresses_just_return_found_address()
    {
        $this->assertEquals(0, Address::count());

        $data = $this->stripeData();
        $address = Address::createFromStripe($data, 'billing');

        $this->assertEquals('Nick Baker', $address->name_line);
        $this->assertEquals('90210', $address->zipcode);
        $this->assertEquals('123 Main Street', $address->street);
        $this->assertEquals('', $address->street_2);
        $this->assertEquals('Los Angeles', $address->city);
        $this->assertEquals('CA', $address->state);
        $this->assertEquals('US', $address->country);

        $address = Address::createFromStripe($data, 'shipping');

        $this->assertEquals('Nick Baker', $address->name_line);
        $this->assertEquals('90210', $address->zipcode);
        $this->assertEquals('123 Main Street', $address->street);
        $this->assertEquals('', $address->street_2);
        $this->assertEquals('Los Angeles', $address->city);
        $this->assertEquals('CA', $address->state);
        $this->assertEquals('US', $address->country);

        $this->assertEquals(1, Address::count());
    }
}
