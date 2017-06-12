<?php

namespace App\Listeners;

use App\Events\OrderSuccess;
use App\Mail\OrderThankYou;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendThankYouNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderSuccess  $event
     * @return void
     */
    public function handle(OrderSuccess $event)
    {
        $order = $event->order;
        Mail::to($order->email)->send(new OrderThankYou($order));
    }
}
