<?php

namespace Modules\Admin\Providers;

use Modules\Admin\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Providers\AuthServiceProvider;

class AdminAuthServiceProvider extends AuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('list-permissions', fn (User $user) => $user->tokenCan('permission.list'));
    }
}
