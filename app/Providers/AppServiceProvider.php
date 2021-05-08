<?php

namespace App\Providers;

use App\View\Components\aside_nav_bar;
use App\View\Components\navbar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Schema::enableForeignKeyConstraints();

        Blade::component('nav-bar',navbar::class);
        Blade::component('aside-nav-bar',aside_nav_bar::class);
    }
}
