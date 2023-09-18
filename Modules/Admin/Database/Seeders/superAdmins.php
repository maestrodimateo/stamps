<?php

use Modules\Admin\Models\Person;

return [
    [
        'email' => 'admin@admin.com',
        'username' => 'main123',
        'password' => 'azerty',
        'person' => [
            'name' => 'Mebale',
            'firstname' => 'Mebale',
            'gender' => Person::GENDERS['male'],
            'birthdate' => '1992-03-12',
            'geo_entity_id' => null,
            'phone' => '066764376',
        ]
    ]
];
