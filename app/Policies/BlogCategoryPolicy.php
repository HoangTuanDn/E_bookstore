<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
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
            ->checkPermissionAccess(config('permission.blog_categories.list'));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function view(User $user, BlogCategory $blogCategory)
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
            ->checkPermissionAccess(config('permission.blog_categories.add'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function update(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.blog_categories.edit'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function delete(User $user = null)
    {
        return auth()
            ->guard('admin')
            ->user()
            ->checkPermissionAccess(config('permission.blog_categories.delete'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function restore(User $user, BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return mixed
     */
    public function forceDelete(User $user, BlogCategory $blogCategory)
    {
        //
    }
}
