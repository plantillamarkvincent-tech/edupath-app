<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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
        Blade::component('university-header', \App\View\Components\UniversityHeader::class);

        // Force HTTPS on Render (and other reverse proxies) so assets and redirects use HTTPS
        if (config('app.env') === 'production') {
            $url->forceScheme('https');
        }
    }
}
