<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Session;

class App
{	
	public static function view($pattern, $attributes = [])
	{
		extract($attributes);

		require_once PUBLIC_ROOT . 'views/' . $pattern;
	}

	public static function abort($code = 404)
	{
		http_response_code($code);
		require PUBLIC_ROOT . "views/errors/{$code}.php";
		die();
	}

	public static function error($message = null)
	{
		Session::flash('message', $message);
		
		http_response_code(200);
		require PUBLIC_ROOT . "views/errors/error.php";
		die();
	}

	public static function message($message, $level = 'default')
	{
		switch ($level) {
			case 'error':
				$bgColor = 'red';
				$color = 'white';
				$title = 'ERROR';
				break;
			case 'warning':
				$bgColor = 'orange';
				$color = 'black';
				$title = 'WARNING';
				break;
			case 'success':
				$bgColor = 'green';
				$color = 'white';
				$title = 'SUCCESS';
				break;
			case 'info':
				$bgColor = 'blue';
				$color = 'white';
				$title = 'INFO';
				break;
			default:
				$bgColor = 'white';
				$color = 'black';
				$title = 'MESSAGE';
				break;
		}

		return "<span style=\"background-color: $bgColor; color: $color;\">$title: $message</span>";
	}
}