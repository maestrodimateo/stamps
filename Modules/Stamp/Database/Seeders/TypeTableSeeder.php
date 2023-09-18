<?php

namespace Modules\Stamp\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Stamp\Models\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['label' => 'Poste', 'price' => 1000]);
        Type::create(['label' => 'Commerce', 'price' => 1500]);
    }
}
