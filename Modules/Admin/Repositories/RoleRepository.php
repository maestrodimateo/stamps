<?php
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\AbstractRepository;

class RoleRepository extends AbstractRepository
{
    protected string $model = Role::class;

    /**
     * Assign permissions to a role
     *
     * @param Role $role
     * @param array $permissions
     *
     * @return void
     */
    public function assignPermissions(Role $role, array $permissions)
    {
        $role->permissions()->sync($permissions);
    }

    /**
     * Detach all the permissions
     *
     * @param Model $role
     * @return bool|null
     */
    public function delete(Model $role): bool|null
    {
        $role->permissions()->detach();
        return parent::delete($role);
    }
}
