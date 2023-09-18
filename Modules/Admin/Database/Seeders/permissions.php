<?php

return [

    "module" => [
        'title' => "Gestion des utilisateurs",
        'code'  => "user:module"
    ],

    "permissions" => [
        
        // users table
        "user" => [
            "create" => "Créer un utilisateur",
            "update" => "Modifier un utilisateur",
            "delete" => "Supprimer un utilisateur",
            "list" => "Lister les utilisateurs",
            "read" => "Visualiser un utilisateur",
            "destroy" => "Détruire un utilisateur",
            "restore" => "Restaurer un utilisateur",
        ],

        // roles table
        "role" => [
            "create" => "Créer un rôle",
            "update" => "Modifier un rôle",
            "delete" => "Supprimer un rôle",
            "list" => "Lister les rôles",
            "read" => "Visualiser un rôle",
        ],

        // permissions table
        "permission" => [
            "list" => "Lister les permissions",
        ]
    ]
];
