<?php

namespace Modules\Core\Policies;

use Modules\Admin\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeoEntityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the resource
     *
     * @param  \App\Models\User\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function list(User $user)
    {
        return $user->tokenCan('geo_entity.list');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function read(User $user)
    {
        return $user->tokenCan('geo_entity.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->tokenCan('geo_entity.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->tokenCan('geo_entity.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->tokenCan('geo_entity.delete');
    }
}
