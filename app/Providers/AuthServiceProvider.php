<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
        
        Gate::define('isSuperAdmin', function ($user) {
            return $user->roles->first()->slug == 'superadmin';
        });

        Gate::define('isAdmin', function ($user) {
            return $user->roles->first()->slug == 'admin';
        });

        Gate::define('isManager', function ($user) {
            return $user->roles->first()->slug == 'manager';
        });

        Gate::define('isSalesman', function ($user) {
            return $user->roles->first()->slug == 'salesman';
        });

        Gate::after(function ($user, $ability, $result, $arguments) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
