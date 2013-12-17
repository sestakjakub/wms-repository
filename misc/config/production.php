<?php
return array(
	'parameters' => array(
		'database' => array(
			'driver' => 'mysql',
			'host' => isset($_ENV['OPENSHIFT_MYSQL_DB_HOST']) ? $_ENV['OPENSHIFT_MYSQL_DB_HOST'] : 'localhost',
			'dbname' => 'wms',
			'user' => isset($_ENV['OPENSHIFT_MYSQL_DB_USERNAME']) ? $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'] : 'test',
			'password' => isset($_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']) ? $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'] : '',
		),
	),
);