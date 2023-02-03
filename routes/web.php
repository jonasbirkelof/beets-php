<?php

use Bramus\Router\Router;
use App\Controllers\AppController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\ProductController;

$Router = new Router();

/**
 * Common Resource Routes:
 * 
 * index 	- GET - Show all listings
 * show 	- GET - Show single listing
 * create 	- GET - Show form to create new listing
 * store 	- POST - Store new listing
 * edit 	- GET - Show form to edit listing
 * update 	- PATCH - Update listing
 * destroy 	- DELETE - Delete listing  
 */

// Home routes
$Router->get('/', [HomeController::class, 'index']);

// Users routes
$Router->get('/users', [UserController::class, 'index']);
$Router->get('/users/{userId}', [UserController::class, 'show']);

// Products routes
$Router->get('/products', [ProductController::class, 'index']);

// General app routes
$Router->set404(function () {
	AppController::view404();
});

// Run it!
$Router->run();