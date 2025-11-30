<?php

namespace App\Providers;

use App\Models\General;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // $site = General::select('og_image', 'logo', 'top_text', 'favicon', 'site_description', 'site_title')->take(1)->first();
        // View::share('site', $site);
    }
}
