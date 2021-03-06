<?php

return array(
	'fetch' => PDO::FETCH_CLASS,
	'default' => 'mysql',
	'connections' => array(
		'mysql' => array(
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => 'wedding',
                    'username'  => 'wedding_user',
                    'password'  => 'password_user',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
		),
                'migration' => array(
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => 'wedding',
                    'username'  => 'wedding_master',
                    'password'  => 'password_master',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ),
	),
    /*
	'migrations' => 'migrations',
	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),
    */
);
