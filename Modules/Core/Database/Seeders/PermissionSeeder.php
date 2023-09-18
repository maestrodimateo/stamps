<?php

namespace Modules\Core\Database\Seeders;

use Modules\Admin\Models\Role;
use Illuminate\Database\Seeder;

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
