<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        # dev
        $is_dev = in_array(request()->getClientIp(), config('ip.dev'));
        config(['app.debug' => $is_dev]);

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
