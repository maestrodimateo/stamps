<?php

namespace Modules\Admin\Database\Seeders;

use Modules\Admin\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::ROLES as $role) {
            Role::create([ 'label' => $role ]);
        }
    }
}
