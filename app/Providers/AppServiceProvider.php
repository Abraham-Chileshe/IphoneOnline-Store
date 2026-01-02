<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Fix for MySQL "Specified key was too long" error
        Schema::defaultStringLength(191);
        
        // Force HTTPS for Gitpod URLs
        if (str_contains(config('app.url'), 'gitpod.dev')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Sidebar Categories View Composer
        \Illuminate\Support\Facades\View::composer('partials.sidebar', function ($view) {
            $categories = \App\Models\Product::where('is_active', true)
                ->where('stock', '>', 0)
                ->select('category', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get();
            
            $view->with('sidebarCategories', $categories);
        });
    }
}
