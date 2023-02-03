<?php

namespace App\Controllers;

use function App\Helpers\view;

class HomeController
{
	public static function index()
	{
		return view('home.php', [
			'title' => 'Home'
		]);
	}
}