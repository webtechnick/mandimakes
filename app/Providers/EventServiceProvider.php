<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ItemSaving' => [
            'App\Listeners\ItemGenerateShortDescription',
        ],
        'App\Events\PhotoSaving' => [
            'App\Listeners\SelectPrimaryPhoto',
        ],
        'App\Events\PhotoDeleting' => [
            'App\Listeners\RemovePhotoFiles',
        ],
        'App\Events\TagDeleting' => [
            'App\Listeners\RemoveTagFromItems',
        ],
        'App\Events\OrderSuccess' => [
            'App\Listeners\SendThankYouNotification',
        ],
        'App\Events\OrderShipped' => [
            'App\Listeners\SendShippmentNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
