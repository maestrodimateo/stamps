<?php
namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\AbstractRepository;

class PermissionRepository extends AbstractRepository
{
    protected string $model = Permission::class;

    /**
     * Group permission by model
     *
     * @return Collection
     */
    public function groupByModel(): Collection
    {
        $permissions = $this->model::query()->get();
        return $permissions
        ->groupBy(fn($permission) => $permission->module)
        ->transform(fn($permission, $key) => $key);
    }
}
