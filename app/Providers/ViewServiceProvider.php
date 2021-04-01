<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('layouts.master', 'App\Http\Controllers\Fontend\MasterController@index');
        view()->composer('fontend.wish_list', 'App\Http\Controllers\Fontend\WishListController@index');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
