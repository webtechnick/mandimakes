<?php

namespace App\Listeners;

use App\Events\ItemSaving;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemGenerateShortDescription
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
     * @param  ItemSaving  $event
     * @return void
     */
    public function handle(ItemSaving $event)
    {
        $event->item->generateShortDescription();
    }
}
