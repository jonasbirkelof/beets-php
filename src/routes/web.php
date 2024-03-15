<?php

use App\Core\App;
use App\Core\Redirect;
use Bramus\Router\Router;
use App\Core\Authenticate as Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Authenticate\LoginController;
use App\Http\Controllers\Authenticate\PasswordController;

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

$Router = new Router();
$Router->setNamespace('\App\Controllers');
$Router->setBasePath('/');

// Root
if (Auth::check()) {
	// Go to dashboard
	$Router->get('/', function () {
		return App::view('dashboard.php', ['title' => 'Dashboard']);
	});
} else {
	// Go to login page
	$Router->get('/', [LoginController::class, 'create']);
}

// Login routes
$Router->mount('/login', function () use ($Router) {
	$Router->before('GET', '*(.*)', function () {
		if (Auth::check()) Redirect::to('/');
	});

	$Router->get('/', [LoginController::class, 'create']);
	$Router->post('/', [LoginController::class, 'store']);
	$Router->delete('/', [LoginController::class, 'destroy']);
});

// Reset password
$Router->mount('/reset-password', function () use ($Router) {
	$Router->get('/', [PasswordController::class, 'create']);
	$Router->post('/', [PasswordController::class, 'store']);
	$Router->get('/new', [PasswordController::class, 'edit']);
	$Router->patch('/new', [PasswordController::class, 'update']);
});

// Users routes
$Router->mount('/users', function () use ($Router) {
	$Router->before('GET', '*(.*)', function () {
		if (! Auth::check()) Redirect::to('/login');
	});

	if (permission('view_users_list')) {
		$Router->get('/', [UserController::class, 'index']);
	}

	if (permission('view_user')) {
		$Router->get('/(\d+)', [UserController::class, 'show']);
	}

	if (permission('add_user')) {
		$Router->get('/create', [UserController::class, 'create']);
		$Router->post('/create', [UserController::class, 'store']);
	}

	if (permission('edit_user')) {
		$Router->get('/(\d+)/edit', [UserController::class, 'edit']);
		$Router->patch('/(\d+)/edit', [UserController::class, 'update']);
	}

	if (permission('delete_user')) {
		$Router->delete('/(\d+)/edit', [UserController::class, 'destroy']);
	}
});

// Profile routes
$Router->mount('/profile', function () use ($Router) {
	$Router->before('GET', '*(.*)', function () {
		if (! Auth::check()) Redirect::to('/login');
	});

	$Router->get('/', [ProfileController::class, 'edit']);
	$Router->patch('/', [ProfileController::class, 'update']);
});

$Router->mount('/about', function () use ($Router) {
	$Router->before('GET', '*(.*)', function () {
		if (! Auth::check()) Redirect::to('/');
	});

	$Router->get('/', function () {
		return App::view('about.php', ['title' => 'About']);
	});
});

$Router->mount('/settings', function () use ($Router) {
	$Router->before('GET', '*(.*)', function () {
		if (! Auth::check()) Redirect::to('/');
	});

	$Router->get('/', function () {
		return App::view('settings.php', ['title' => 'Settings']);
	});
});

// General app routes
$Router->set404(function () {
	App::abort(404);
});

// Run it!
$Router->run();