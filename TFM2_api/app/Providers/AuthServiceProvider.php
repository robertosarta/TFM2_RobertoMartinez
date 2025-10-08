<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); //Por si en un futuro lo uso con policies

        Gate::define('ver-usuarios', function ($user)
        {
            return $user->role === 'admin';
        });
        
        Gate::define('eliminar-usuarios', function ($user)
        {
            return $user->role === 'admin';
        }); 
    }
}
