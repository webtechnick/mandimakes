<?php

namespace Tests\Feature;

use App\Mail\OrderShipped;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderCanBeTrackedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function order_can_provide_tracking_information()
    {
        $order = $this->create('App\Order');

        $this->assertFalse($order->hasTracking());

        $order->tracking_number = 'asdf';
        $order->save();

        $this->assertTrue($order->hasTracking());

        $this->assertContains('usps', $order->trackingUrl());
        $this->assertContains('asdf', $order->trackingUrl());
    }

    /** @test */
    public function order_will_send_out_notification_to_user_when_tracking_is_added()
    {
        Mail::fake();
        $this->signInAdmin();
        $order = $this->create('App\Order');

        $data = [
            'tracking_number' => 'asdf'
        ];

        $response = $this->patch('/admin/orders/edit/' . $order->id, $data);

        $this->assertTrue($order->fresh()->hasTracking());

        Mail::assertSent(OrderShipped::class, function ($mail) use ($order) {
            return $mail->order->id === $order->id && $mail->hasTo($order->email);
        });
    }
}
