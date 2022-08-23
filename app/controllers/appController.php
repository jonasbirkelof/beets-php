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
	public function home()
	{
		return view('home');
	}
}