<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.home');
});

Route::prefix('admin')->group(function (){
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


});

