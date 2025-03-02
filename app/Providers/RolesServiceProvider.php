<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('role', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($roles)) : ?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });

        Blade::directive('can', function ($permission) {
            //$permissions = auth()->user()->roles[0] ? auth()->user()->roles[0]->permissions->pluck('slug') : [];
            return "<?php if(auth()->check() && auth()->user()->hasPermission($permission)) : ?>"; //return this if statement inside php tag
        });

        Blade::directive('endcan', function () {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });
    }
}
