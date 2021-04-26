<?php


use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MailController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\backend\OrderController as BackendOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Fontend\CartController;
use App\Http\Controllers\Fontend\CheckOutController;
use App\Http\Controllers\Fontend\ContactController;
use App\Http\Controllers\Fontend\HomeController;
use App\Http\Controllers\Fontend\OrderController;
use App\Http\Controllers\Fontend\PaypalController;
use App\Http\Controllers\Fontend\WishListController;
use App\Http\Controllers\Fontend\SendContactMailController;
use App\Http\Controllers\ShipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\ProductController;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\Fontend\ProductController as FdProductController;
use App\Http\Controllers\Fontend\BlogController as FdBlogController;

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


/*admin route*/
Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'loginForm'])
        ->name('auth.adminLogin');

    Route::post('/login', [AuthController::class, 'loginAction'])
        ->name('auth.admin_login');

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth_admin')
        ->name('admin.home');

    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('auth.admin_logout');

    /*category route*/
    Route::prefix('categories')->middleware('auth_admin')->group(function () {
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

    /*menu route*/
    Route::prefix('menus')->middleware('auth_admin')->group(function () {

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

    /*product route*/
    Route::prefix('products')->middleware('auth_admin')->group(function () {

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

    /*slider route*/
    Route::prefix('sliders')->middleware('auth_admin')->group(function () {

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

    /*setting route*/
    Route::prefix('settings')->middleware('auth_admin')->group(function () {

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

    /*user admin route*/
    Route::prefix('users')->middleware('auth_admin')->group(function () {

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

    /*role route*/
    Route::prefix('roles')->middleware('auth_admin')->group(function () {

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

    /*coupon route*/
    Route::prefix('coupons')->middleware('auth_admin')->group(function () {

        Route::get('/index', [CouponController::class, 'index'])
            ->name('coupons.index');

        Route::get('/create', [CouponController::class, 'create'])
            ->name('coupons.create');

        Route::post('/store', [CouponController::class, 'store'])
            ->name('coupons.store');

        Route::get('/edit/{id}', [CouponController::class, 'edit'])
            ->name('coupons.edit');

        Route::post('/update/{id}', [CouponController::class, 'update'])
            ->name('coupons.update');

        Route::post('/destroy/{id}', [CouponController::class, 'destroy'])
            ->name('coupons.destroy');

    });

    /*permission route*/
    Route::prefix('permissions')->middleware('auth_admin')->group(function () {

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

    /*ship route*/
    Route::prefix('ships')->middleware('auth_admin')->group(function () {

        Route::get('/index', [ShipController::class, 'index'])
            ->name('ships.index');

        Route::get('/create', [ShipController::class, 'create'])
            ->name('ships.create');

        Route::post('/store', [ShipController::class, 'store'])
            ->name('ships.store');

        Route::get('/edit/{id}', [ShipController::class, 'edit'])
            ->name('ships.edit');

        Route::post('/update/{id}', [ShipController::class, 'update'])
            ->name('ships.update');

        Route::post('/destroy/{id}', [ShipController::class, 'destroy'])
            ->name('ships.destroy');
    });

    /*order route*/
    Route::prefix('orders')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BackendOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/show/{id}', [BackendOrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/update/{id}', [BackendOrderController::class, 'update'])
            ->name('orders.update');

        Route::post('/destroy/{id}', [BackendOrderController::class, 'destroy'])
            ->name('orders.destroy');
    });

    /*blog category*/
    Route::prefix('blog/categories')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BlogCategoryController::class, 'index'])
            ->name('blog_categories.index');

        Route::get('/show/{id}', [BlogCategoryController::class, 'show'])
            ->name('blog_categories.show');

        Route::get('/create', [BlogCategoryController::class, 'create'])
            ->name('blog_categories.create');

        Route::post('/store', [BlogCategoryController::class, 'store'])
            ->name('blog_categories.store');

        Route::get('/edit/{id}', [BlogCategoryController::class, 'edit'])
            ->name('blog_categories.edit');


        Route::post('/update/{id}', [BlogCategoryController::class, 'update'])
            ->name('blog_categories.update');

        Route::post('/destroy/{id}', [BlogCategoryController::class, 'destroy'])
            ->name('blog_categories.destroy');
    });

    /*blog route*/

    Route::prefix('blogs')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BlogController::class, 'index'])
            ->name('blogs.index');

        Route::get('/show/{id}', [BlogController::class, 'show'])
            ->name('blogs.show');

        Route::get('/create', [BlogController::class, 'create'])
            ->name('blogs.create');

        Route::post('/store', [BlogController::class, 'store'])
            ->name('blogs.store');

        Route::get('/edit/{id}', [BlogController::class, 'edit'])
            ->name('blogs.edit');

        Route::post('/update/{id}', [BlogController::class, 'update'])
            ->name('blogs.update');

        Route::post('/destroy/{id}', [BlogController::class, 'destroy'])
            ->name('blogs.destroy');
    });

    /*mail route*/
    Route::prefix('mails')->middleware('auth_admin')->group(function () {
        Route::post('/order/{id}', [MailController::class, 'confirm'])
            ->name('mails.send_mail');
        Route::post('/coupon/{id}/share', [MailController::class, 'shareCoupon'])
            ->name('mails.share_coupon');

    });


    Route::group(['prefix' => 'filemanager'], function () {
        Lfm::routes();
    });
});

Route::redirect('/', '/vn/home');
Route::Group(['prefix' => '{language}'], function () {
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        /*account*/
        Route::prefix('account')->group(function () {
            Route::get('/my', [CustomerController::class, 'index'])
                ->name('account.my');

            Route::post('/login', [CustomerController::class, 'login'])
                ->name('account.login');

            Route::post('/register', [CustomerController::class, 'register'])
                ->name('account.register');

            Route::post('/logout', [CustomerController::class, 'logout'])
                ->name('account.logout');
        });

        /*shop*/
        Route::get('/shop', [FdProductController::class, 'index'])
            ->name('home.shop');

        Route::get('/shop/{slug}', [FdProductController::class, 'show'])
            ->name('home.shop.single_product');

        /*blog*/
        Route::get('/blog', [FdBlogController::class, 'index'])
            ->name('home.blog');

        Route::get('/blog/{slug}', [FdBlogController::class, 'show'])
            ->name('home.blog.detail');

        Route::post('/blog/comment', [FdBlogController::class, 'comment'])
            ->name('home.blog.comment');

        /*product*/
        Route::post('/product/{slug}/review', [FdProductController::class, 'review'])
            ->name('home.product.review');

        /*cart*/
        Route::get('/cart', [CartController::class, 'index'])
            ->name('home.cart');

        Route::post('/cart/store', [CartController::class, 'store'])
            ->name('home.cart.store');

        Route::post('/cart/update/{id}', [CartController::class, 'update'])
            ->name('home.cart.update');

        Route::post('/cart/destroy/{id}', [CartController::class, 'destroy'])
            ->name('home.cart.destroy');

        /*checkout*/
        Route::get('/checkout/{slug?}', [CheckOutController::class, 'index'])
            ->name('home.checkout');

        Route::post('/checkout/payment/{slug?}', [PayPalController::class, 'payment'])
            ->name('home.payment');

        Route::get('/checkout/payment/success', [PayPalController::class, 'success'])
            ->name('home.payment.success');

        /*order*/
        Route::post('/order/{slug?}', [OrderController::class, 'store'])
            ->name('home.order');

        Route::get('/order', [OrderController::class, 'index'])
            ->name('order.index');

        Route::post('/order/delete/{id}', [OrderController::class, 'destroy'])
            ->name('order.destroy');

        /*wishlist*/
        Route::get('/wish-list', [WishListController::class, 'index'])
            ->name('home.wish_list');

        /*contact*/
        Route::get('/contact', [ContactController::class, 'index'])
            ->name('home.concat');

        Route::post('/contact/send', [SendContactMailController::class, 'send'])
            ->name('home.concat.send');

        Route::post('/contact/register', [ContactController::class, 'register'])
            ->name('home.register_email');

        Route::get('/error', [WishListController::class, 'index'])
            ->name('home.error');
    });
});




