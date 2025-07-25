<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Inertia::share([
            'auth' => function () {
                foreach (['customer', 'owner', 'admin', 'web'] as $guard) {
                    if (Auth::guard($guard)->check()) {
                        return [
                            'user' => Auth::guard($guard)->user(),
                            'guard' => $guard,
                        ];
                    }
                }
                return null;
            },
        ]);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
