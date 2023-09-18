<?php

namespace Modules\Stamp\Database\Seeders;

use Illuminate\Database\Seeder;

class StampDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(TypeTableSeeder::class);
    }
}
