<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class HelperFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('customerHelper',function() {
            return new \App\Helpers\CustomHelper;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
