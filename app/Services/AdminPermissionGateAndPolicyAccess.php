<?php

namespace App\Services;
use Illuminate\Support\Facades\Gate;

class AdminPermissionGateAndPolicyAccess
{
    public function setGatePolicyAccess(){
        $this->defineGateCategory();
    }

    public function defineGateCategory(){
        Gate::define('category-viewAny', 'App\Policies\CategoryPolicy@viewAny');
        Gate::define('category-create', 'App\Policies\CategoryPolicy@create');
        Gate::define('category-update', 'App\Policies\CategoryPolicy@update');
        Gate::define('category-delete', 'App\Policies\CategoryPolicy@delete');
    }

}