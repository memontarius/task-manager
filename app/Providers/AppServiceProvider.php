<?php

namespace App\Providers;

use App\Services\VisitorCounter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VisitorCounter::class, fn (Application $app) => new VisitorCounter(60));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isLocal() && Cookie::has('XDEBUG_SESSION')) {
            Cookie::queue('XDEBUG_SESSION', 1);
        }
    }
}
