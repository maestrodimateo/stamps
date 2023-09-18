<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\GeoEntity;

class GeoEntityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $geoCreated = GeoEntity::create([
            "name" => "Gabon",
            "type" => GeoEntity::COUNTRY,
        ]);

        $geoCreated->children()->create([
                "name" => "Libreville",
                "type" => "TOWN",
            ]
        );
    }
}
