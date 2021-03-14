<?php


use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;

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

});

