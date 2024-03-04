<?php

namespace App\Http\Controllers\Authenticate;

use App\Core\App;
use App\Core\CSRF;
use App\Core\Redirect;
use App\Core\Session;
use App\Http\Feedback;
use App\Models\Authenticate\Password;

class PasswordController
{

	private const PASSWORD_SEND_EMAIL_SUCCESS = "An email has been sent if the address was registered. Check your inbox.";
	private const PASSWORD_RESET_UPDATE_FAIL = "The password has NOT been changed. Check your inputs.";
	private const PASSWORD_RESET_UPDATE_ERROR = "An error has occured";
	private const PASSWORD_RESET_UPDATE_SUCCESS = "The password was changed! Use it to log in.";

	public static function create()
	{
		Feedback::for('success')->callout([
			'text' => static::PASSWORD_SEND_EMAIL_SUCCESS,
			'style' => 'success',
		]);

		CSRF::newToken();

		return App::view('authenticate/reset-password.php');
	}
	
	public static function store()
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}
		
		$email = escape($_POST['email']);
		$rowId = Password::checkEmail($email);

		// If email does not exist, return to view with same message as success
		if (! $rowId) {
			Redirect::to('/reset-password')->with('feedback', 'success');
		}
		
		// Flag a password reset
		$token = Password::generateToken($rowId);

		// Create and send email
		Password::sendResetEmail($email, $token);
		
		Redirect::to('/reset-password')->with('feedback', 'success');	
	}

	public static function edit()
	{
		Feedback::for('password_update_failed')->callout([
			'text' => static::PASSWORD_RESET_UPDATE_FAIL,
			'style' => 'failure',
		]);

		Feedback::for('error')->callout([
			'text' => static::PASSWORD_RESET_UPDATE_ERROR,
			'style' => 'danger',
		]);

		Feedback::for('success')->callout([
			'text' => static::PASSWORD_RESET_UPDATE_SUCCESS,
			'style' => 'success',
		]);

		$token = isset($_GET['token']) ? escape($_GET['token']) : null;

		// Check of the token exists or is valid
		if (! Password::checkToken($token)) {
			App::abort();
		}

		CSRF::newToken();

		return App::view('authenticate/new-password.php');
	}

	public static function update()
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}

		$token = escape($_POST['token']);
		$passwordNew = escape($_POST['password_new']);
		$passwordRepeat = escape($_POST['password_repeat']);

		$userId = Password::getUserId($token);

		if (! $userId) {
			Redirect::to("/reset-password/new?token=$token")->with('feedback', 'error');
		}

		if (! Password::update($passwordNew, $passwordRepeat, $userId, $userId)) {
			Redirect::to("/reset-password/new?token=$token")->with('feedback', 'password_update_failed');
		}
		
		// Rest the session
		Session::flush();

		// Delete the token to make the link invalid
		Password::deleteToken($userId);

		// Send a confirmation email
		$email = Password::getEmail($userId);
		Password::sendConfirmationEmail($email);

		Redirect::to("/login")->with('feedback', 'password_reset_success');
	}
}