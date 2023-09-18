<?php
namespace Modules\Admin\Providers;

use Modules\Admin\Models\User;
use Modules\Admin\Observers\UserObserver;
use App\Providers\EventServiceProvider as MainEventServiceProvider;

class EventServiceProvider extends MainEventServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
