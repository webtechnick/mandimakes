<?php

namespace Tests\Feature;

use App\Mail\NewOrder;
use App\Mail\OrderThankYou;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CanPurchaseItemTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_purchase_whatever_is_in_cart()
    {
        Mail::fake();

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
        $this->assertEquals(1, $order->status); // CC approved
        $this->assertTrue($order->isGood());

        // Assert mail was sent
        Mail::assertSent(NewOrder::class, function ($mail) use ($order) {
            return $mail->order->id === $order->id;
        });
        Mail::assertSent(OrderThankYou::class, function ($mail) use ($order) {
            return $mail->hasTo($order->email);
        });
    }

    /** @test */
    public function a_guest_can_purchase_whatever_is_in_cart_and_create_account()
    {
        Mail::fake();

        $this->buildCart();
        $data = $this->stripeData();

        // We have no orders.
        $this->assertEquals(0, Order::count());
        $this->assertEquals(0, User::count());

        $response = $this->post('checkout', $data);

        // We created the order, and the user.
        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, User::count());
        $order = Order::first();
        $this->assertEquals(1, $order->status);
        $this->assertTrue($order->isGood());
    }

    /** @test */
    public function user_cannot_purchase_with_declined_card()
    {
        Mail::fake();

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
