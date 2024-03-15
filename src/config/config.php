<?php

// Environment variables
define('APP_NAME', $_ENV['APP_NAME']);
define('APP_DESCRIPTION', $_ENV['APP_DESCRIPTION']);
define('APP_ID', $_ENV['APP_ID']);
define('APP_ENV', $_ENV['APP_ENV']);
define('APP_DEBUG', $_ENV['APP_DEBUG']);
define('APP_URL', $_ENV['APP_URL']);
define('APP_COPYRIGHT', $_ENV['APP_COPYRIGHT']);

// Development variables
if (APP_ENV == 'development') {
	$appFolder = '';
	$dbTablePrefix = '';
}

// Production variables
if (APP_ENV == 'production') {
	$appFolder = '/subdomain';
	$dbTablePrefix = '';
}

// Paths
define('APP_FOLDER', $appFolder);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . APP_FOLDER);
define('VIEWS', ROOT . '/public/views');
define('PARTIALS', ROOT . '/public/partials');
define('ASSETS', '/public/assets');
define('IMAGES', '/public/assets/images');
define('CSS', '/public/assets/css');
define('JAVASCRIPT', '/public/assets/js');
define('STORAGE', '/public/storage');

// Database
define('DB_TABLE_PREFIX', $dbTablePrefix);
define('DB_USER_ACCOUNTS', DB_TABLE_PREFIX . 'admin__user_accounts');
define('DB_ROLES', DB_TABLE_PREFIX . 'admin__roles');
define('DB_PERMISSIONS', DB_TABLE_PREFIX . 'admin__permissions');
define('DB_PERMISSIONS_REL', DB_TABLE_PREFIX . 'admin__permissions_relations');

// Form validation error mesages
define('FORM_ERROR_ALPHA', "Enter only letters (a-z, A-Z)");
define('FORM_ERROR_ALPHA_NUMERIC', "Enter only letters (a-z, A-Z) and numbers");
define('FORM_ERROR_EMAIL', "Enter a valid email address");
define('FORM_ERROR_FAULTY_VALUE', "Invalid input");
define('FORM_ERROR_MATCH', "Invalid characters");
define('FORM_ERROR_MATCHING', "The fields does not match");
define('FORM_ERROR_NAME', "Name contains invalid characters");
define('FORM_ERROR_NUMERIC', "Enter only numbers");
define('FORM_ERROR_PASSWORD', "Invalid password");
define('FORM_ERROR_REQUIRED', "The field is required");
define('FORM_ERROR_STR_MAX', "Input is too long");
define('FORM_ERROR_STR_MIN', "Input is too short");
define('FORM_ERROR_UNIQUE', "The value is already in use");

// Misc
define('DEFAULT_FILE_EXTENSION', '.php');
define('PASSWORD_MIN_LENGTH', 4);
define('PASSWORD_MAX_LENGTH', 50);
define('PASSWORD_RESET_TOKEN_EXPIRATION', 3600); // seconds
define('PROFILE_IMAGE_MAX_SIZE', 10000000); // 10000000 = 10 MB
define('PROFILE_IMAGE_MAX_SIZE_MB', PROFILE_IMAGE_MAX_SIZE / 1000000);