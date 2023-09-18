<?php
namespace Modules\Admin\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Admin\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Services\AbstractService;
use Modules\Admin\Repositories\RoleRepository;

class RoleService extends AbstractService
{

    /**
     * constructor
     *
     * @param RoleRepository $roleRepository
     * @param Request $request
     */
    public function __construct(RoleRepository $roleRepository, Request $request)
    {
        parent::__construct($roleRepository, $request);
    }

    /**
     * Create a new role and assign permissions
     * @override
     *
     *
     * @return Role
     */
    public function create(): Role
    {
        return DB::transaction(function () {

            $newRole = $this->repository->create($this->request->only(['label', 'description']));

            $this->repository->assignPermissions($newRole, $this->request->permissions);

            return $newRole;
        });

    }

    /**
     * Update a role and assign permission if possible
     * @override
     *
     * @param Role $role
     *
     * @return bool
     */
    public function update(Model $role): bool
    {
        return DB::transaction(function () use ($role) {

            $this->repository->update($this->request->only(['label', 'description']), $role);

            $this->repository->assignPermissions($role, $this->request->permissions);

            return true;
        });
    }

    /**
     * Delete a role
     * @override
     *
     * @param Role $role
     *
     */
    public function delete(Model $role): bool|null
    {
        if ($role->users()->exists()) {
            return false;
        }
        return $this->repository->delete($role);
    }

    /**
     * Get the roles
     *
     * @return Collection|LengthAwarePaginator
     */
    public function get(): Collection|LengthAwarePaginator
    {
        $this->repository->builder->where('label', '<>', Role::ROLES['super']);

        return parent::get();
    }
}
