<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Http\Resources\UserResource;
use Modules\Admin\Services\AuthentificationService;
use Modules\Admin\Http\Requests\ChangePasswordRequest;

/**
 * @group Admin management
 */
class AuthController extends Controller
{
    public function __construct(protected AuthentificationService $authentificationService)
    {}

    /**
     * Log in the user
     *
     * @bodyParam identity string required an email or a username
     * @bodyParam password string required
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->except('identity');

        if (!$this->authentificationService->authenticate($credentials)) {
            return response()->json(
                [ 'message' => 'Identifiants incorrects' ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->authentificationService->updateLastLogin();

        return response()->json([
            'access_token' => $this->authentificationService->issueToken(),
            'user' => UserResource::make(auth()->user()->loadMissing('person'))
        ], Response::HTTP_OK);
    }

    /**
     * Log out the user
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(): Response
    {
        $this->authentificationService->revokeToken();
        return response()->noContent();
    }

    /**
     * Edit the password
     *
     * @bodyParam current_password string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     *
     * @param ChangePasswordRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(ChangePasswordRequest $request)
    {
        $this->authentificationService->editPassword($request);

        return response()->noContent();
    }
}
