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

   /* Route::get('/iframe', function () {
        return view('admin.iframe');
    })
        ->middleware('auth_admin')
        ->name('admin.home');*/

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
            ->middleware('can:menu-viewAny')
            ->name('menus.index');

        Route::get('/create', [MenuController::class, 'create'])
            ->middleware('can:menu-create')
            ->name('menus.create');

        Route::post('/store', [MenuController::class, 'store'])
            ->name('menus.store');

        Route::get('/edit/{id}', [MenuController::class, 'edit'])
            ->middleware('can:menu-update')
            ->name('menus.edit');

        Route::post('/update/{id}', [MenuController::class, 'update'])
            ->name('menus.update');

        Route::post('/destroy/{id}', [MenuController::class, 'destroy'])
            ->middleware('can:menu-delete')
            ->name('menus.destroy');

    });

    /*product route*/
    Route::prefix('products')->middleware('auth_admin')->group(function () {

        Route::get('/index', [ProductController::class, 'index'])
            ->middleware('can:product-viewAny')
            ->name('products.index');

        Route::get('/create', [ProductController::class, 'create'])
            ->middleware('can:product-create')
            ->name('products.create');

        Route::post('/store', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/edit/{id}', [ProductController::class, 'edit'])
            ->middleware('can:product-update')
            ->name('products.edit');

        Route::post('/update/{id}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::post('/destroy/{id}', [ProductController::class, 'destroy'])
            ->middleware('can:product-delete')
            ->name('products.destroy');

    });

    /*slider route*/
    Route::prefix('sliders')->middleware('auth_admin')->group(function () {

        Route::get('/index', [SliderController::class, 'index'])
            ->middleware('can:slider-viewAny')
            ->name('sliders.index');

        Route::get('/create', [SliderController::class, 'create'])
            ->middleware('can:slider-create')
            ->name('sliders.create');

        Route::post('/store', [SliderController::class, 'store'])
            ->name('sliders.store');

        Route::get('/edit/{id}', [SliderController::class, 'edit'])
            ->middleware('can:slider-update')
            ->name('sliders.edit');

        Route::post('/update/{id}', [SliderController::class, 'update'])
            ->name('sliders.update');

        Route::post('/destroy/{id}', [SliderController::class, 'destroy'])
            ->middleware('can:slider-delete')
            ->name('sliders.destroy');

    });

    /*setting route*/
    Route::prefix('settings')->middleware('auth_admin')->group(function () {

        Route::get('/index', [SettingController::class, 'index'])
            ->middleware('can:setting-viewAny')
            ->name('settings.index');

        Route::get('/create', [SettingController::class, 'create'])
            ->middleware('can:setting-create')
            ->name('settings.create');

        Route::post('/store', [SettingController::class, 'store'])
            ->name('settings.store');

        Route::get('/edit/{id}', [SettingController::class, 'edit'])
            ->middleware('can:setting-update')
            ->name('settings.edit');

        Route::post('/update/{id}', [SettingController::class, 'update'])
            ->name('settings.update');

        Route::post('/destroy/{id}', [SettingController::class, 'destroy'])
            ->middleware('can:setting-delete')
            ->name('settings.destroy');

    });

    /*user admin route*/
    Route::prefix('users')->middleware('auth_admin')->group(function () {

        Route::get('/index', [UserController::class, 'index'])
            ->middleware('can:admin-viewAny')
            ->name('users.index');

        Route::get('/create', [UserController::class, 'create'])
            ->middleware('can:admin-create')
            ->name('users.create');

        Route::post('/store', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/edit/{id}', [UserController::class, 'edit'])
            ->middleware('can:admin-update')
            ->name('users.edit');

        Route::post('/update/{id}', [UserController::class, 'update'])
            ->name('users.update');

        Route::post('/destroy/{id}', [UserController::class, 'destroy'])
            ->middleware('can:admin-delete')
            ->name('users.destroy');

    });

    /*role route*/
    Route::prefix('roles')->middleware('auth_admin')->group(function () {

        Route::get('/index', [RoleController::class, 'index'])
            ->middleware('can:role-viewAny')
            ->name('roles.index');

        Route::get('/create', [RoleController::class, 'create'])
            ->middleware('can:role-create')
            ->name('roles.create');

        Route::post('/store', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/edit/{id}', [RoleController::class, 'edit'])
            ->middleware('can:role-update')
            ->name('roles.edit');

        Route::post('/update/{id}', [RoleController::class, 'update'])
            ->name('roles.update');

        Route::post('/destroy/{id}', [RoleController::class, 'destroy'])
            ->middleware('can:role-delete')
            ->name('roles.destroy');
    });

    /*coupon route*/
    Route::prefix('coupons')->middleware('auth_admin')->group(function () {

        Route::get('/index', [CouponController::class, 'index'])
            ->middleware('can:coupon-viewAny')
            ->name('coupons.index');

        Route::get('/create', [CouponController::class, 'create'])
            ->middleware('can:coupon-create')
            ->name('coupons.create');

        Route::post('/store', [CouponController::class, 'store'])
            ->name('coupons.store');

        Route::post('/destroy/{id}', [CouponController::class, 'destroy'])
            ->middleware('can:coupon-delete')
            ->name('coupons.destroy');

    });

    /*permission route*/
    Route::prefix('permissions')->middleware('auth_admin')->group(function () {

        Route::get('/index', [PermissionController::class, 'index'])
            ->middleware('can:permission-viewAny')
            ->name('permissions.index');

        Route::get('/create', [PermissionController::class, 'create'])
            ->middleware('can:permission-create')
            ->name('permissions.create');

        Route::post('/store', [PermissionController::class, 'store'])
            ->name('permissions.store');

        Route::get('/edit/{id}', [PermissionController::class, 'edit'])
            ->middleware('can:permission-update')
            ->name('permissions.edit');

        Route::post('/update/{id}', [PermissionController::class, 'update'])
            ->name('permissions.update');

        Route::post('/destroy/{id}', [PermissionController::class, 'destroy'])
            ->middleware('can:permission-delete')
            ->name('permissions.destroy');

    });

    /*ship route*/
    Route::prefix('ships')->middleware('auth_admin')->group(function () {

        Route::get('/index', [ShipController::class, 'index'])
            ->middleware('can:ship-viewAny')
            ->name('ships.index');

        Route::get('/create', [ShipController::class, 'create'])
            ->middleware('can:ship-create')
            ->name('ships.create');

        Route::post('/store', [ShipController::class, 'store'])
            ->name('ships.store');

        Route::get('/edit/{id}', [ShipController::class, 'edit'])
            ->name('ships.edit');

        Route::post('/update/{id}', [ShipController::class, 'update'])
            /*            ->middleware('can:ship-update')*/
            ->name('ships.update');

        Route::post('/destroy/{id}', [ShipController::class, 'destroy'])
            ->middleware('can:ship-delete')
            ->name('ships.destroy');
    });

    /*order route*/
    Route::prefix('orders')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BackendOrderController::class, 'index'])
            ->middleware('can:order-viewAny')
            ->name('orders.index');

        Route::get('/show/{id}', [BackendOrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/update/{id}', [BackendOrderController::class, 'update'])
            ->name('orders.update');

        Route::post('/destroy/{id}', [BackendOrderController::class, 'destroy'])
            ->middleware('can:order-delete')
            ->name('orders.destroy');

        Route::get('/print/{id}', [BackendOrderController::class, 'printOrder'])
            ->name('orders.print');
    });

    /*blog category*/
    Route::prefix('blog/categories')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BlogCategoryController::class, 'index'])
            ->middleware('can:blog_category-viewAny')
            ->name('blog_categories.index');

        Route::get('/show/{id}', [BlogCategoryController::class, 'show'])
            ->name('blog_categories.show');

        Route::get('/create', [BlogCategoryController::class, 'create'])
            ->middleware('can:blog_category-create')
            ->name('blog_categories.create');

        Route::post('/store', [BlogCategoryController::class, 'store'])
            ->name('blog_categories.store');

        Route::get('/edit/{id}', [BlogCategoryController::class, 'edit'])
            ->middleware('can:blog_category-update')
            ->name('blog_categories.edit');


        Route::post('/update/{id}', [BlogCategoryController::class, 'update'])
            ->name('blog_categories.update');

        Route::post('/destroy/{id}', [BlogCategoryController::class, 'destroy'])
            ->middleware('can:blog_category-delete')
            ->name('blog_categories.destroy');
    });

    /*blog route*/

    Route::prefix('blogs')->middleware('auth_admin')->group(function () {

        Route::get('/index', [BlogController::class, 'index'])
            ->middleware('can:blog-viewAny')
            ->name('blogs.index');

        Route::get('/show/{id}', [BlogController::class, 'show'])
            ->name('blogs.show');

        Route::get('/create', [BlogController::class, 'create'])
            ->middleware('can:blog-create')
            ->name('blogs.create');

        Route::post('/store', [BlogController::class, 'store'])
            ->name('blogs.store');

        Route::get('/edit/{id}', [BlogController::class, 'edit'])
            ->middleware('can:blog-update')
            ->name('blogs.edit');

        Route::post('/update/{id}', [BlogController::class, 'update'])
            ->name('blogs.update');

        Route::post('/destroy/{id}', [BlogController::class, 'destroy'])
            ->middleware('can:blog-delete')
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




