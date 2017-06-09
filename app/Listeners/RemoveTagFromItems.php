<?php

namespace App\Listeners;

use App\Events\TagDeleting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveTagFromItems
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
     * @param  TagDeleting  $event
     * @return void
     */
    public function handle(TagDeleting $event)
    {
        $tag = $event->tag;
        $tag->items()->detach();
    }
}
