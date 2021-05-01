<?php

namespace App\Services;
use Illuminate\Support\Facades\Gate;

class AdminPermissionGateAndPolicyAccess
{
    public function setGatePolicyAccess(){
        $this->defineGateCategory();
        $this->defineGateAdmin();
        $this->defineGateBlogCategory();
        $this->defineGateBlog();
        $this->defineGateMenu();
        $this->defineGatePermission();
        $this->defineGateProduct();
        $this->defineGateRole();
        $this->defineGateSetting();
        $this->defineGateSlider();
        $this->defineGateCoupon();
        $this->defineGateOrder();
        $this->defineGateShip();
    }

    public function defineGateCategory(){
        Gate::define('category-viewAny', 'App\Policies\CategoryPolicy@viewAny');
        Gate::define('category-create', 'App\Policies\CategoryPolicy@create');
        Gate::define('category-update', 'App\Policies\CategoryPolicy@update');
        Gate::define('category-delete', 'App\Policies\CategoryPolicy@delete');
    }
    public function defineGateAdmin(){
        Gate::define('admin-viewAny', 'App\Policies\AdminPolicy@viewAny');
        Gate::define('admin-create', 'App\Policies\AdminPolicy@create');
        Gate::define('admin-update', 'App\Policies\AdminPolicy@update');
        Gate::define('admin-delete', 'App\Policies\AdminPolicy@delete');
    }
    public function defineGateBlogCategory(){
        Gate::define('blog_category-viewAny', 'App\Policies\BlogCategoryPolicy@viewAny');
        Gate::define('blog_category-create', 'App\Policies\BlogCategoryPolicy@create');
        Gate::define('blog_category-update', 'App\Policies\BlogCategoryPolicy@update');
        Gate::define('blog_category-delete', 'App\Policies\BlogCategoryPolicy@delete');
    }
    public function defineGateBlog(){
        Gate::define('blog-viewAny', 'App\Policies\BlogPolicy@viewAny');
        Gate::define('blog-create', 'App\Policies\BlogPolicy@create');
        Gate::define('blog-update', 'App\Policies\BlogPolicy@update');
        Gate::define('blog-delete', 'App\Policies\BlogPolicy@delete');
    }
    public function defineGateMenu(){
        Gate::define('menu-viewAny', 'App\Policies\MenuPolicy@viewAny');
        Gate::define('menu-create', 'App\Policies\MenuPolicy@create');
        Gate::define('menu-update', 'App\Policies\MenuPolicy@update');
        Gate::define('menu-delete', 'App\Policies\MenuPolicy@delete');
    }
    public function defineGatePermission(){
        Gate::define('permission-viewAny', 'App\Policies\PermissionPolicy@viewAny');
        Gate::define('permission-create', 'App\Policies\PermissionPolicy@create');
        Gate::define('permission-update', 'App\Policies\PermissionPolicy@update');
        Gate::define('permission-delete', 'App\Policies\PermissionPolicy@delete');
    }
    public function defineGateProduct(){
        Gate::define('product-viewAny', 'App\Policies\ProductPolicy@viewAny');
        Gate::define('product-create', 'App\Policies\ProductPolicy@create');
        Gate::define('product-update', 'App\Policies\ProductPolicy@update');
        Gate::define('product-delete', 'App\Policies\ProductPolicy@delete');
    }
    public function defineGateRole(){
        Gate::define('role-viewAny', 'App\Policies\RolePolicy@viewAny');
        Gate::define('role-create', 'App\Policies\RolePolicy@create');
        Gate::define('role-update', 'App\Policies\RolePolicy@update');
        Gate::define('role-delete', 'App\Policies\RolePolicy@delete');
    }
    public function defineGateSetting(){
        Gate::define('setting-viewAny', 'App\Policies\SettingPolicy@viewAny');
        Gate::define('setting-create', 'App\Policies\SettingPolicy@create');
        Gate::define('setting-update', 'App\Policies\SettingPolicy@update');
        Gate::define('setting-delete', 'App\Policies\SettingPolicy@delete');
    }
    public function defineGateSlider(){
        Gate::define('slider-viewAny', 'App\Policies\SliderPolicy@viewAny');
        Gate::define('slider-create', 'App\Policies\SliderPolicy@create');
        Gate::define('slider-update', 'App\Policies\SliderPolicy@update');
        Gate::define('slider-delete', 'App\Policies\SliderPolicy@delete');
    }

    public function defineGateCoupon(){
        Gate::define('coupon-viewAny', 'App\Policies\CouponPolicy@viewAny');
        Gate::define('coupon-create', 'App\Policies\CouponPolicy@create');
        Gate::define('coupon-delete', 'App\Policies\CouponPolicy@delete');
    }
    public function defineGateOrder(){
        Gate::define('order-viewAny', 'App\Policies\OrderPolicy@viewAny');
        Gate::define('order-delete', 'App\Policies\OrderPolicy@delete');
    }
    public function defineGateShip(){
        Gate::define('ship-viewAny', 'App\Policies\ShipPolicy@viewAny');
        Gate::define('ship-create', 'App\Policies\ShipPolicy@create');
        Gate::define('ship-update', 'App\Policies\ShipPolicy@update');
        Gate::define('ship-delete', 'App\Policies\ShipPolicy@delete');
    }

}