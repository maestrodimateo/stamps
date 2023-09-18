<?php

namespace Modules\Logger\Providers;

use Modules\Admin\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Providers\AuthServiceProvider;

class LoggerAuthServiceProvider extends AuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('list-logs', fn (User $user) => $user->tokenCan('log.list'));
    }
}
