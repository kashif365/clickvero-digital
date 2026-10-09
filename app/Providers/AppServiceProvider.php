<?php

namespace App\Providers;

use App\Services\SeoResolver;
use App\Services\SitePayload;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        view()->composer('partials.seo-meta', function (View $view) {
            $view->with('seo', app(SeoResolver::class)->resolve());
        });

        view()->composer('spa', function (View $view) {
            $view->with('site', app(SitePayload::class)->toArray());
        });
    }
}
