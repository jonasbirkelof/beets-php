<?php

// App
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/..');
define('APP_URL', $_ENV['APP_URL']);
define('APP_NAME', $_ENV['APP_NAME']);
define('APP_DESCRIPTION', $_ENV['APP_DESCRIPTION']);
define('APP_ID', $_ENV['APP_ID']);
define('APP_COPYRIGHT', $_ENV['APP_COPYRIGHT']);

// Paths
define('PUBLIC_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PUBLIC_URL', APP_URL . '/public/');
define('ASSETS_URL', APP_URL . '/assets');
define('ASSETS', PUBLIC_ROOT . 'assets/');
define('STORAGE', PUBLIC_ROOT . 'storage/');

// Password
define('PASSWORD_MIN_LENGTH', 4);
define('PASSWORD_MAX_LENGTH', 50);
define('PASSWORD_RESET_TOKEN_EXPIRATION', 3600); // seconds

// Database 
define('DB_USER_ACCOUNTS', 'admin__user_accounts');
define('DB_ROLES', 'admin__roles');
define('DB_PERMISSIONS', 'admin__permissions');
define('DB_PERMISSIONS_REL', 'admin__permissions_relations');

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
define('PROFILE_IMAGE_MAX_SIZE', 10000000); // 10000000 = 10 MB
define('PROFILE_IMAGE_MAX_SIZE_MB', PROFILE_IMAGE_MAX_SIZE / 1000000);