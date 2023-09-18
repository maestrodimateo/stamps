<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Admin\Models\Role;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Admin\Services\RoleService;
use Modules\Admin\Http\Requests\RoleRequest;
use Modules\Admin\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Admin management
 *
 */
class RoleController extends Controller
{
    /**
     * Handle the role business logic
     *
     * @var RoleService
     */
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Get all the roles
     *
     * @queryParam search string allow the research
     * @queryParam paginate integer add pagination possibility
     *
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        $this->authorize('list', Role::class);

        $roles = $this->roleService->search('label', ['permissions'])->get();

        return RoleResource::collection($roles);
    }

    /**
     * Show a specific role
     *
     * @param Role $role
     *
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        $this->authorize('read', $role);

        return RoleResource::make($role);
    }

    /**
     * Create a role
     *
     * @bodyParam label string required
     * @bodyParam description string
     * @bodyParam permissions array required The permissions for this role
     *
     * @param RoleRequest $request
     *
     * @return JsonResponse
     */
    public function create(RoleRequest $request): JsonResponse
    {
        $this->authorize('create', Role::class);

        $newRole = $this->roleService->create();

        return response()->json([ 'role' => RoleResource::make($newRole) ], Response::HTTP_CREATED);
    }

    /**
     * Update a specific role
     *
     * @bodyParam label string required
     * @bodyParam description string
     * @bodyParam permissions array required The permissions for this role
     *
     * @param RoleRequest $request
     * @param Role $role
     *
     * @return RoleResource
     */
    public function update(RoleRequest $request, Role $role): RoleResource
    {
        $this->authorize('update', $role);

        $this->roleService->update($role);

        return RoleResource::make($role->refresh());
    }

    /**
     * Delete a role
     *
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function delete(Role $role): JsonResponse
    {
        $this->authorize('delete', $role);

        return ($this->roleService->delete($role)) ?
        response()->noContent():
        response()->json([
            'message' => "Impossible de supprimer: Role utilisé"
        ], Response::HTTP_FORBIDDEN);
    }
}
