<?php

namespace App\Controllers;

use function App\Helpers\view;

class AppController
{	
	public static function view404()
	{
		return view('404.php', [
			'title' => '404'
		]);
	}
}