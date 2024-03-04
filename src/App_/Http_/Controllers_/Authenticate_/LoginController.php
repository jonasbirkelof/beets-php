<?php

namespace App\Http\Controllers\Authenticate;

use App\Core\App;
use App\Core\Redirect;
use App\Http\Feedback;
use App\Models\Authenticate\Login;

class LoginController
{
	private const LOGIN_FAILED = "Login failed. Check your credentials.";
	private const LOGIN_PASSWORD_RESET_SUCCESS = "The password was changed";

	public static function create()
	{
		Feedback::for('login_failed')->callout([
			'text' => static::LOGIN_FAILED,
			'style' => 'warning',
		]);

		Feedback::for('password_reset_success')->callout([
			'text' => static::LOGIN_PASSWORD_RESET_SUCCESS,
			'style' => 'success',
		]);

		return App::view('authenticate/login.php');
	}

	public static function store()
	{
		// Attempt to log in with submitted credentials (stored in $_POST)
		$userId = Login::attempt();

		if (! $userId) {
			Redirect::to('/login')->with('feedback', 'login_failed');
		}

		// Store user information in session
		Login::accept($userId);

		Redirect::to("/");
	}

	public static function destroy()
	{
		// Destroy the session and cookie
		Login::logout();
		
		Redirect::to("/");
	}
}