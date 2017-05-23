<?php

namespace App\Listeners;

use App\Events\PhotoSaving;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SelectPrimaryPhoto
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
     * @param  PhotoSaving  $event
     * @return void
     */
    public function handle(PhotoSaving $event)
    {
        $photo = $event->photo;
        $item = $photo->item()->select(['id'])->first();

        if (!empty($item) && $item->photos()->count() == 0) {
            $photo->makePrimary();
        }
    }
}
