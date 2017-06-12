<?php

namespace Tests\Feature;

use App\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CanPurchaseItemTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_purchase_whatever_is_in_cart()
    {
        // Given user is signed in and has a cart
        $this->signIn();
        $this->buildCart();
        $data = $this->stripeData();

        // We have no orders.
        $this->assertEquals(0, Order::count());

        // Post to checkout
        $response = $this->post('checkout', $data);

        // Confirm the order is created and status is good
        $this->assertEquals(1, Order::count());
        $order = Order::first();
        $this->assertEquals(1, $order->status);
    }

    /** @test */
    public function user_cannot_purchase_with_declined_card()
    {
        $this->signIn();
        $this->buildCart();
        $data = $this->stripeData([
            'stripeToken' => 'tok_chargeDeclined'
        ]);

        // We have no orders.
        $this->assertEquals(0, Order::count());

        // Post to checkout
        $response = $this->post('checkout', $data);

        // Confirm the order is created and status is good
        $this->assertEquals(1, Order::count());
        $order = Order::first();
        $this->assertEquals(2, $order->status);
    }
}
