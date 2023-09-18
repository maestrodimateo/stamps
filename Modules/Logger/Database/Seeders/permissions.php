<?php

return [

    "module" => [
        'title' => "Gestion des logs",
        'code'  => "logger:module"
    ],

    "permissions" => [
        // users table
        "log" => [
            "list" => "Lister le journal d'activité",
        ],
    ]
];
