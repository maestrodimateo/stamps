<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Admin\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Admin\Services\UserService;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Admin management
 *
 */
class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    /**
     * Get all the users
     * @authenticated
     * @queryParam search string allow the research
     * @queryParam paginate integer : add pagination possibility
     *
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
       $this->authorize('list', User::class);

       $users = $this->userService->fullTextSearch(['role:id,label', 'person.birthplace'])->get();

       return UserResource::collection($users);
    }

    /**
     * Show a specific user
     * @authenticated
     * @param User $user
     *
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        $this->authorize('read', $user);

        return UserResource::make($user->loadMissing(['person.birthplace', 'role']));
    }

    /**
     * Create a user
     * @authenticated
     * @bodyParam email string required
     * @bodyParam username string
     * @bodyParam file File The user's picture
     * @bodyParam role_id string The user's picture
     * @bodyParam person[name] string required The user's name
     * @bodyParam person[firstname] string The user's firstname
     * @bodyParam person[maiden_name] string The user's maiden_name
     * @bodyParam person[gender] string required The user's gender -> F or M
     * @bodyParam person[geo_entity_id] string required The user's birthdate
     * @bodyParam person[birthdate] date required The user's birthdate
     * @bodyParam person[phone] string required The user's phone -> only numeric values
     *
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function create(UserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $createdUser = $this->userService->create();

        return response()
        ->json(UserResource::make($createdUser->loadMissing('person.birthplace')), Response::HTTP_CREATED);
    }

    /**
     * Update a user
     * @authenticated
     * @bodyParam email string required
     * @bodyParam username string
     * @bodyParam file File The user's picture
     * @bodyParam role_id string The user's picture
     * @bodyParam person[name] string required The user's name
     * @bodyParam person[firstname] string The user's firstname
     * @bodyParam person[maiden_name] string The user's maiden_name
     * @bodyParam person[gender] string required The user's gender -> F or M
     * @bodyParam person[geo_entity_id] string required The user's birthdate
     * @bodyParam person[birthdate] date required The user's birthdate
     * @bodyParam person[phone] string The user's phone -> only numeric values
     *
     * @param UserRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $this->userService->update($user);

        return UserResource::make($user->refresh()->loadMissing('person.birthplace'));
    }

    /**
     * Ban a user
     * @authenticated
     * @param User $user
     *
     * @return Response
     */
    public function delete(User $user): Response
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return response()->noContent();
    }

    /**
     * Destroy a user once for all
     *
     * @param User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->authorize('forceDelete', $user);

        $this->userService->destroy($user);

        return response()->noContent();
    }

    /**
     * Restore a user
     * @authenticated
     * @param User $user
     *
     * @return Response
     */
    public function restore(User $user)
    {
        $this->authorize('restore', $user);

        $this->userService->restore($user);

        return response()->noContent();
    }
}
