<?php

namespace App\Controllers;

use function App\Helpers\view;

class AppController
{
	/**
	 * Home
	 * View home page
	 *
	 * @return void
	 */
	public static function home()
	{
		return view('home', [
			'title' => 'Home'
		]);
	}
}