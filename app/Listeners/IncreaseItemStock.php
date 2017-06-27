<?php

namespace App\Listeners;

use App\Events\SaleDeleting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseItemStock
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
     * @param  SaleDeleting  $event
     * @return void
     */
    public function handle(SaleDeleting $event)
    {
        $event->sale->item->increaseStock($event->sale->qty);
    }
}
