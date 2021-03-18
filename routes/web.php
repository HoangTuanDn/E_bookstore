<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return view('admin.home');
});

Route::prefix('admin')->group(function (){

    Route::prefix('auth')->group(function (){

        Route::get('/login', [AuthController::class, 'loginForm'])
            ->name('auth.adminLogin');

        Route::post('/login', [AuthController::class, 'loginAction'])
           ->name('auth.admin_login');
    });

    Route::prefix('categories')->group(function (){

        Route::get('/index', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

    });

    Route::prefix('menus')->group(function (){

        Route::get('/index', [MenuController::class, 'index'])
            ->name('menus.index');

        Route::get('/create', [MenuController::class, 'create'])
            ->name('menus.create');

        Route::post('/store', [MenuController::class, 'store'])
            ->name('menus.store');

        Route::get('/edit/{id}', [MenuController::class, 'edit'])
            ->name('menus.edit');

        Route::post('/update/{id}', [MenuController::class, 'update'])
            ->name('menus.update');

        Route::post('/destroy/{id}', [MenuController::class, 'destroy'])
            ->name('menus.destroy');

    });


    Route::prefix('products')->group(function (){

        Route::get('/index', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/store', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/edit/{id}', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::post('/update/{id}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::post('/destroy/{id}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

    });

    Route::prefix('sliders')->group(function (){

        Route::get('/index', [SliderController::class, 'index'])
            ->name('sliders.index');

        Route::get('/create', [SliderController::class, 'create'])
            ->name('sliders.create');

        Route::post('/store', [SliderController::class, 'store'])
            ->name('sliders.store');

        Route::get('/edit/{id}', [SliderController::class, 'edit'])
            ->name('sliders.edit');

        Route::post('/update/{id}', [SliderController::class, 'update'])
            ->name('sliders.update');

        Route::post('/destroy/{id}', [SliderController::class, 'destroy'])
            ->name('sliders.destroy');

    });

    Route::prefix('settings')->group(function (){

        Route::get('/index', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::get('/create', [SettingController::class, 'create'])
            ->name('settings.create');

        Route::post('/store', [SettingController::class, 'store'])
            ->name('settings.store');

        Route::get('/edit/{id}', [SettingController::class, 'edit'])
            ->name('settings.edit');

        Route::post('/update/{id}', [SettingController::class, 'update'])
            ->name('settings.update');

        Route::post('/destroy/{id}', [SettingController::class, 'destroy'])
            ->name('settings.destroy');

    });

//    'middleware' => ['web', 'auth']
    Route::group(['prefix' => 'filemanager'], function () {
        Lfm::routes();
    });

});

