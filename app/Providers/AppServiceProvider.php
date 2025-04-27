<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //

    // Force HTTPS in production
    // This method is called when the application is booted
    public function boot()
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}
}
