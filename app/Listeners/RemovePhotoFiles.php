<?php

namespace App\Listeners;

use App\Events\PhotoDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\File;

class RemovePhotoFiles
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
     * @param  PhotoDeleting  $event
     * @return void
     */
    public function handle(PhotoDeleting $event)
    {
        $photo = $event->photo;

        File::delete(public_path($photo->path)); // Original
        File::delete(File::glob(public_path($photo->baseDir() . '/*x' . $photo->name))); // All thumbnails
    }
}
