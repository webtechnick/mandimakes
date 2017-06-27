<?php

namespace App\Listeners;

use App\Events\OrderDeleting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PutSaleItemsBackInStock
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
     * @param  OrderDeleting  $event
     * @return void
     */
    public function handle(OrderDeleting $event)
    {
        //
    }
}
