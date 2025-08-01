<?php

namespace App\Providers;

use App\Auth\TokenGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class TokenAuthProvider extends ServiceProvider
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
        Auth::extend('token', function ($app, $name, array $config) {
            return new TokenGuard(Auth::createUserProvider($config['provider']));
        });
    }
}
