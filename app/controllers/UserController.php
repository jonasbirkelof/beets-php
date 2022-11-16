<?php

namespace App\Controllers;

use App\Models\User;
use function App\Helpers\view;

class UserController
{
	public static function index()
	{
		return view('users.index', [
			'title' => 'Users'
		], User::getAll());
	}

	public static function show(int $userId)
	{
		return view('users.show',[
			'title' => 'User'
		], User::get($userId));
	}
}