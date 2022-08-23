<?php

namespace App\Controllers;

use App\Models\User;
use function App\Helpers\view;

class UserController
{
	/**
	 * Index
	 * List all users
	 *
	 * @return void
	 */
	public function index()
	{
		return view('users.index');
	}

	/**
	 * Show
	 * Show a single user
	 *
	 * @param [type] $userId
	 * @return void
	 */
	public static function show($userId) 
	{
		// request a view and pass data from the model
		return view('users.show',
			User::get($userId)
		);
	}
}