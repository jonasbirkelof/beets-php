<?php

// Set tiezone
date_default_timezone_set("Europe/Stockholm");

// Start a new session
session_start();

// Require Composer Autoloader
require __DIR__ . "../../vendor/autoload.php";

// Require routes
require __DIR__ . "../../routes/web.php";

// Reset flash messages
App\Core\Session::unflash();
