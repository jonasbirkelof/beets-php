<?php

namespace App\Models\Authenticate;

use App\Core\Session;
use App\Core\Database as DB;
use App\Core\Authenticate as Auth;

class Login extends Auth
{
	/**
	 * Make a login attempt using email and password.
	 */
	public static function attempt()
	{
		$inputEmail = $_POST['email'];
		$inputPassword = $_POST['password'];

		$sql = "SELECT id, password FROM " . DB_USER_ACCOUNTS . " WHERE email = :email AND status = :status";
		$result = DB::query($sql, ['email' => $inputEmail, 'status' => 1])->fetch();

		return ($result && (password_verify($inputPassword, $result['password'])))
			? $result['id']
			: false;
	}

	/**
	 * Update timestamp for last login.
	 */
	private static function updateLastLogin($userId)
	{
		$lastLogin = date('Y-m-d H:i:s');

		$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET last_login = :lastLogin	WHERE id = :id";
		DB::query($sql, ['lastLogin' => $lastLogin, 'id' => $userId,]);
	}
	
	/**
	 * Generate a user session on successful login.
	 */
	public static function accept($userId)
	{
		$sql = "SELECT id, first_name, last_name, email, image, role_id FROM " . DB_USER_ACCOUNTS . " WHERE id = :id";
		$user = DB::query($sql, ['id' => $userId])->fetch();
		
		$_SESSION['user'] = [
			'id' => $user['id'],
			'firsName' => $user['first_name'],
			'lastName' => $user['last_name'],
			'fullName' => $user['first_name'] . ' ' . $user['last_name'],
			'initials' => substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1),
			'email' => $user['email'],
			'image' => $user['image'],
			'role_id' => $user['role_id'],
			'role' => Role::find($user['role_id']),
			'permissions' => Permission::findByRole($user['role_id'])
		];

		session_regenerate_id(true);

		static::updateLastLogin($userId);
	}

	/**
	 * Log out a user by destroyling the session.
	 */
	public static function logout()
	{
		Session::destroy();
	}
}