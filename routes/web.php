<?php

use App\Controllers\AppController;
use App\Controllers\UserController;
use Bramus\Router\Router;

$Route = new Router();

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

// General app routes
$Route->get('/', [AppController::class, 'home']);

// Users routes
$Route->get('/users', [UserController::class, 'index']);
$Route->get('/users/{userId}', [UserController::class, 'show']);

//Custom 404 Handler
$Route->set404(function () {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	echo '404, route not found!';
});

// Run it!
$Route->run();