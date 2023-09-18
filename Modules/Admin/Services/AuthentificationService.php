<?php
namespace Modules\Admin\Services;

use Modules\Admin\Http\Requests\ChangePasswordRequest;

class AuthentificationService
{
    /**
     * Create the access token and send it
     *
     * @return string
     */
    public function issueToken(): string
    {
        $permissions = auth()->user()->role->permissions->pluck('code')->toArray();

        $newAccessToken = auth()->user()->createToken(time(), $permissions);

        auth()->user()->permissions = $newAccessToken->accessToken->abilities;

        return $newAccessToken->plainTextToken;
    }

    /**
     * Delete the current Access token
     *
     * @return void
     */
    public function revokeToken(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }

    /**
     * Edit the user's password
     *
     * @param ChangePasswordRequest $request
     *
     * @return bool
     */
    public function editPassword(ChangePasswordRequest $request)
    {
        auth()->user()->password = $request->password;

        if (auth()->user()->password_changed) {
            auth()->user()->password_changed = true;
        }

        auth()->user()->save();

        return true;
    }

    /**
     * Authenticate the user
     *
     * @param array $credentials
     * @param string|null $guard
     *
     * @return bool
     */
    public function authenticate(array $credentials, string $guard = null): bool
    {
        return auth($guard)->attempt($credentials);
    }

    /**
     * Update the last login
     *
     * @param string|null $guard
     * @return void
     */
    public function updateLastLogin(string $guard = null): void
    {
        auth($guard)->user()->update(['last_login' => now()->toString()]);
    }
}
