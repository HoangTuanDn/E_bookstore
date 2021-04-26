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
        view()->composer('partials.header', 'App\Http\Controllers\Backend\MasterController@index');
        view()->composer('partials.blog_sidebar', 'App\Http\Controllers\Fontend\MasterController@blogSidebar');
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
