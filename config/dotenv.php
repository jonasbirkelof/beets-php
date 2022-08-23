<?php

use Dotenv\Dotenv;

// Set the location of .env (shold be app root)
// $dotenv_location = $_SERVER["DOCUMENT_ROOT"] . '/filesystem';
$dotenv_location = __DIR__ . '../../';

$dotenv = Dotenv::createImmutable($dotenv_location);
$dotenv->load();

// Keys that must exist in .env and also can not be empty
$dotenv->required([
	'DB_CONNECTION',
	'DB_HOST',
	'DB_PORT',
	'DB_DATABASE',
	'DB_USERNAME',
])->notEmpty();

// Keys that must exist in .env but can be empty
$dotenv->required([
	'DB_PASSWORD',
]);