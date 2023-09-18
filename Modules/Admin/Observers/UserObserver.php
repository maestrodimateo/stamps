<?php
namespace Modules\Admin\Observers;

use Modules\Admin\Models\User;
use Illuminate\Support\Facades\Storage;

use Modules\Logger\Models\Log;

class UserObserver
{
    /**
     * Handle the user "deleted"
     *
     * @param User user
     *
     * @return void
     */
    public function deleted(User $user)
    {
        if (Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }

        Log::info("Utilisateur {$user->username} supprimé.", "DELETE");
    }

    /**
     * Handle the user "updating" event
     *
     * @return void
     */
    public function updated(User $user)
    {
        Log::info("Utilisateur {$user->username} modifié.", "UPDATE");
    }
}
