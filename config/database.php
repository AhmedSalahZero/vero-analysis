<?php
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

	// 'default' => 'mysql_production',
	'default' => 'mysql',
    'migrations' => 'migrations',
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

		'sqlite' => [
			'driver' => 'sqlite',
			'url' => env('DATABASE_URL'),
			'database' => env('DB_DATABASE', database_path('database.sqlite')),
			'prefix' => '',
			'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
		],

		'mysql' => [
			'driver' => 'mysql',
			'url' => env('DATABASE_URL'),
			'host' => env('DB_HOST', '127.0.0.1'),
			'port' => env('DB_PORT', '3306'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
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
		], 'mysql_production' => [
			'driver' => 'mysql',
			'url' => env('DATABASE_URL'),
			'host' => 'veroanalysis.com',
			'port' => env('DB_PORT', '3306'),
			'database' => 'veroanalysis_db',
			'username' => 'veroanalysis_production',
			'password' => 'ho_OQYRjSqGB',
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
		]

	]
];
