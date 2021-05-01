<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.settings.list'));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function view(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.settings.add'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function update(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.settings.edit'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function delete(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.settings.delete'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function restore(User $user, Setting $setting)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Setting  $setting
     * @return mixed
     */
    public function forceDelete(User $user, Setting $setting)
    {
        //
    }
}
