<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart', function($app) {
            // return new \App\Libs\Cart($app->make('request'));
            return new \App\Libs\Cart();
        });

        $this->app->bind('mms', function($app) {
            return new \App\Libs\MMS();
        });

        $this->app->bind('mailgun', function($app) {
            return new \Mailgun\Mailgun(config('services.mailgun.secret'));
        });
    }
}
