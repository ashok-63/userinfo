<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        // 'access' => [
        //     'driver' => 'odbc',
        //     'dsn' => 'DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=D:\login.mdb;',
        //     'database' => 'login.mdb',
        //     'username' => '',
        //     'password' => ''
        // ],

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => env('DB_CONNECTION'),
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            // 'host' => '127.0.0.1:3306',
            // 'port' =>'3306',
            // 'database' => 'installinfo',
            // 'username' => 'root',
            // 'password' => '',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ], 'mysql2' => [
            'driver' => env('DB_CONNECTION_SECOND'),
            'host' => env('DB_HOST_SECOND', '127.0.0.1'),
            'port' => env('DB_PORT_SECOND', '3307'),
            'database' => env('DB_DATABASE_SECOND', 'forge'),
            'username' => env('DB_USERNAME_SECOND', 'forge'),
            'password' => env('DB_PASSWORD_SECOND', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ], 'mysql3' => [
            'driver' => env('DB_CONNECTION_THREE'),
            'host' => env('DB_HOST_THREE', '127.0.0.1'),
            'port' => env('DB_PORT_THREE', '3307'),
            'database' => env('DB_DATABASE_THREE', 'forge'),
            'username' => env('DB_USERNAME_THREE', 'forge'),
            'password' => env('DB_PASSWORD_THREE', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ], 'mysql4' => [
            'driver' => env('DB_CONNECTION_FOUR'),
            'host' => env('DB_HOST_FOUR', '127.0.0.1'),
            'port' => env('DB_PORT_FOUR', '3307'),
            'database' => env('DB_DATABASE_FOUR', 'forge'),
            'username' => env('DB_USERNAME_FOUR', 'forge'),
            'password' => env('DB_PASSWORD_FOUR', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ], 'mysql5' => [
            'driver' => env('DB_CONNECTION_FIVE'),
            'host' => env('DB_HOST_FIVE', '127.0.0.1'),
            'port' => env('DB_PORT_FIVE', '3307'),
            'database' => env('DB_DATABASE_FIVE', 'forge'),
            'username' => env('DB_USERNAME_FIVE', 'forge'),
            'password' => env('DB_PASSWORD_FIVE', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ], 'mysql6' => [
            'driver' => env('DB_CONNECTION_SIX'),
            'host' => env('DB_HOST_SIX', '127.0.0.1'),
            'port' => env('DB_PORT_SIX', '3307'),
            'database' => env('DB_DATABASE_SIX', 'forge'),
            'username' => env('DB_USERNAME_SIX', 'forge'),
            'password' => env('DB_PASSWORD_SIX', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],

        'mysql7' => [
            'driver' => env('DB_CONNECTION_SEVEN'),
            'host' => env('DB_HOST_SEVEN', '127.0.0.1'),
            'port' => env('DB_PORT_SEVEN', '3307'),
            'database' => env('DB_DATABASE_SEVEN', 'forge'),
            'username' => env('DB_USERNAME_SEVEN', 'forge'),
            'password' => env('DB_PASSWORD_SEVEN', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],

        'location' => [
            'driver' => env('DB_CONNECTION_EIGHT'),
            'host' => env('DB_HOST_EIGHT', '127.0.0.1'),
            'port' => env('DB_PORT_EIGHT', '3307'),
            'database' => env('DB_DATABASE_EIGHT', 'forge'),
            'username' => env('DB_USERNAME_EIGHT', 'forge'),
            'password' => env('DB_PASSWORD_EIGHT', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],

        'actbatchregionvalidator' => [
            'driver' => env('DB_CONNECTION_NINE'),
            'host' => env('DB_HOST_NINE', '127.0.0.1'),
            'port' => env('DB_PORT_NINE', '3307'),
            'database' => env('DB_DATABASE_NINE', 'forge'),
            'username' => env('DB_USERNAME_NINE', 'forge'),
            'password' => env('DB_PASSWORD_NINE', ''),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
        ],







        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
