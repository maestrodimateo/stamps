# Patrimoine logement
Projet consistant en la gestion des logements de l'état

## Etapes d'installation du projet

1. Pré-requis
    * php ^8.0
        * Modules à installer
            ```bash
             sh sudo apt install php8.0-common php8.0-mysql php8.0-xml php8.0-xmlrpc php8.0-curl php8.0-gd php8.0-imagick php8.0-cli php8.0-dev php8.0-imap php8.0-mbstring php8.0-opcache php8.0-soap php8.0-zip php8.0-intl php8.0-pgsql -y 
            ```
        * décommenter les extensions __pgsql et pdo_pgsql__ dans __/etc/php/8.0/cli/php.ini__

    * PostgreSQL
        * Extensions à installer
            - Extension importante pour la recherche. N'oubliez pas créer un index sur les champs de recherche
        ```sql
        CREATE EXTENSION pg_trgm;
        ```
2. installation

    * Cloner le projet depuis le dépôt : 
    ```bash
        clone git@gitlab.aninf.ga:laravel-api/patrimoine-logement.git
    ```
    * Entrer dans le dossier du projey
    * Copier et renommer le fichier .env.example en .env dans la racine du projet
    * Configurer la base de données dans le fichier .env
    * Executer composer install
    * Executer php artisan key:generate
    * Executer php artisan migrate
    * Executer php artisan module:seed

- Liens utiles
    - [package pour générer la documentation de l'api](https://github.com/ovac/idoc)
    - [package pour la modularisation laravel](https://docs.laravelmodules.com/v9/introduction)
