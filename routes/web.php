<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\fontend\CartController;
use App\Http\Controllers\fontend\ContactController;
use App\Http\Controllers\fontend\HomeController;
use App\Http\Controllers\fontend\WishListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\ProductController;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\fontend\ProductController as FdProductController;

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




Route::prefix('admin')->group(function (){

    Route::get('/login', [AuthController::class, 'loginForm'])
        ->name('auth.adminLogin');

    Route::post('/login', [AuthController::class, 'loginAction'])
        ->name('auth.admin_login');

    Route::get('/', function () {
        return view('admin.home');
    })->middleware('auth_admin')->name('home');

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('auth.admin_logout');

    Route::prefix('categories')->middleware('auth_admin')->group(function (){
        Route::get('/index', [CategoryController::class, 'index'])
            ->middleware('can:category-viewAny')
            ->name('categories.index');

        Route::get('/create', [CategoryController::class, 'create'])
            ->middleware('can:category-create')
            ->name('categories.create');

        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->middleware('can:category-update')
            ->name('categories.edit');

        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])
            ->middleware('can:category-delete')
            ->name('categories.destroy');

    });

    Route::prefix('menus')->middleware('auth_admin')->group(function (){

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


    Route::prefix('products')->middleware('auth_admin')->group(function (){

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

    Route::prefix('sliders')->middleware('auth_admin')->group(function (){

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

    Route::prefix('settings')->middleware('auth_admin')->group(function (){

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

    Route::prefix('users')->middleware('auth_admin')->group(function (){

        Route::get('/index', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/store', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/edit/{id}', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::post('/update/{id}', [UserController::class, 'update'])
            ->name('users.update');

        Route::post('/destroy/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');

    });

    Route::prefix('roles')->middleware('auth_admin')->group(function (){

        Route::get('/index', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::get('/create', [RoleController::class, 'create'])
            ->name('roles.create');

        Route::post('/store', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/edit/{id}', [RoleController::class, 'edit'])
            ->name('roles.edit');

        Route::post('/update/{id}', [RoleController::class, 'update'])
            ->name('roles.update');

        Route::post('/destroy/{id}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');

    });

    Route::prefix('permissions')->middleware('auth_admin')->group(function (){

        Route::get('/index', [PermissionController::class, 'index'])
            ->name('permissions.index');

        Route::get('/create', [PermissionController::class, 'create'])
            ->name('permissions.create');

        Route::post('/store', [PermissionController::class, 'store'])
            ->name('permissions.store');

        Route::get('/edit/{id}', [PermissionController::class, 'edit'])
            ->name('permissions.edit');

        Route::post('/update/{id}', [PermissionController::class, 'update'])
            ->name('permissions.update');

        Route::post('/destroy/{id}', [PermissionController::class, 'destroy'])
            ->name('permissions.destroy');

    });

    Route::group(['prefix' => 'filemanager'], function () {
        Lfm::routes();
    });

});

Route::prefix('home')->group(function (){
    Route::get('/',[HomeController::class, 'index'])
        ->name('home');

    Route::prefix('account')->group(function () {
        Route::get('/my',[CustomerController::class, 'index'])
            ->name('account.index');
    });

    Route::get('/shop', [FdProductController::class, 'index'])
        ->name('home.shop');

    Route::get('/cart',[CartController::class, 'index'])
        ->name('home.cart');

    Route::get('/checkout',[CartController::class, 'index'])
        ->name('home.checkout');

    Route::get('/wish-list',[WishListController::class, 'index'])
        ->name('home.wish_list');

    Route::get('/contact',[ContactController::class, 'index'])
        ->name('home.concat');

    Route::get('/error',[WishListController::class, 'index'])
        ->name('home.error');


});


