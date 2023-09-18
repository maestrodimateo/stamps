<?php
namespace Modules\Admin\Database\Seeders;

use Modules\Admin\Models\Role;
use Illuminate\Database\Seeder;
use Modules\Admin\Models\Person;
use Modules\Core\Models\GeoEntity;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Role::getOne('super')->users()->create([
            'email' => 'admin@admin.com',
            'username' => 'main123',
            'password' => 'azerty',
        ]);

        $user->person()->create([
            'name' => 'Mebale',
            'firstname' => 'Mebale',
            'gender' => Person::GENDERS['male'],
            'birthdate' => '1992-03-12',
            'phone' => '066764376',
        ]);
    }
}
