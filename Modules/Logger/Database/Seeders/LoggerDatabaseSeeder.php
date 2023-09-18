<?php

namespace Modules\Logger\Database\Seeders;

use Illuminate\Database\Seeder;

class LoggerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
    }
}
