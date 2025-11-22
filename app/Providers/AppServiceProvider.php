<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_ends_with(request()->getHost(), '.ngrok-free.dev') || str_ends_with(request()->getHost(), '.ngrok.io')) {
            URL::forceScheme('https');
        }

        Gate::define('admin', function ($user) {
            return $user->is_admin === 1;
        });
    }
}
