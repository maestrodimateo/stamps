<?php

namespace Modules\Stamp\Policies;

use Modules\Admin\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the resource
     *
     * @param  Modules\Admin\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function list(User $user)
    {
        return $user->tokenCan('user.list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Modules\Admin\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function read(User $user)
    {
        return $user->tokenCan('user.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Modules\Admin\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('user.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Modules\Admin\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->tokenCan('user.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Modules\Admin\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->tokenCan('user.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Modules\Admin\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return $user->tokenCan('user.restore');
    }
}
