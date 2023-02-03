<?php

namespace App\Controllers;

use App\Models\User;
use function App\Helpers\view;

class UserController
{
	public static function index()
	{
		return view('users/index.php', [
			'title' => 'Users',
			'usersList' => User::getAll()
		]);
	}

	public static function show(int $userId)
	{
		return view('users/show.php', [
			'title' => 'User',
			'user' => User::get($userId)
		]);
	}
}