<?php

namespace Modules\Stamp\Database\Seeders;

use Modules\Admin\Models\Role;
use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\PermissionsHandler;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionIds = PermissionsHandler::getFrom(__DIR__ . "/permissions.php")->create();

        // Assigns permissions to superAdmin role
        Role::getOne('super')->permissions()->syncWithoutDetaching($permissionIds);
    }
}
