<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url): void
    {
        // Register Tailwind as the pagination view
        Paginator::useTailwind();

        // Force HTTPS schema in non-local environments
        if(env('APP_ENV') !== 'local')
        {
            $url->forceSchema('https');
        }
    }
}
