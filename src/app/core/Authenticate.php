<?php

declare(strict_types=1);

namespace App\Core;

class Authenticate
{
	/**
	 * Check if user is logged in.
	 * 
	 * @return bool
	 */
	public static function check(): bool
	{
		return isset($_SESSION['user']) ? true : false;
	}

	/**
	 * Check if user is NOT logged in.
	 * 
	 * @return bool
	 */
	public static function guest(): bool
	{
		return ! static::check();
	}

	/**
	 * Return logged in user data array.
	 * 
	 * @return mixed
	 */
	public static function user(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user'] : null;
	}

	/**
	 * Return logged in user ID.
	 * 
	 * @return mixed
	 */
	public static function id(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
	}

	/**
	 * Return logged in user first name.
	 * 
	 * @return mixed
	 */
	public static function firstName(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['firstName'] : null;
	}

	/**
	 * Return logged in user last name.
	 * 
	 * @return mixed
	 */
	public static function lastName(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['lastName'] : null;
	}

	/**
	 * Return logged in user full name.
	 * 
	 * @return mixed
	 */
	public static function fullName(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['fullName'] : null;
	}

	/**
	 * Return logged in user initials.
	 * 
	 * @return mixed
	 */
	public static function initials(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['initials'] : null;
	}

	/**
	 * Return logged in user email.
	 * 
	 * @return mixed
	 */
	public static function email(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['email'] : null;
	}

	/**
	 * Return logged in user profile image name.
	 * 
	 * @return mixed
	 */
	public static function image(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['image'] : null;
	}

	/**
	 * Return logged in user role.
	 * 
	 * @param null $key
	 * 
	 * @return mixed
	 */
	public static function role($key = null): mixed
	{
		$return = $key ? $_SESSION['user']['role'][$key] : $_SESSION['user']['role'];

		return isset($_SESSION['user']) ? $return : null;
	}

	/**
	 * Return logged in user permissions.
	 * 
	 * @return mixed
	 */
	public static function permissions(): mixed
	{		
		return isset($_SESSION['user']) ? $_SESSION['user']['permissions'] : null;
	}

	/**
	 * Abort with an error page if the user is not logged in.
	 * 
	 * @param int $code
	 * 
	 * @return void
	 */
	public static function abort($code = 401): void
	{
		if (! static::check()) App::abort($code);
	}

	/**
	 * Update the user session with a given $key and $value.
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public static function set($key, $value): void
	{
		$_SESSION['user'][$key] = $value;
	}

	/**
	 * Check if the logged in user has a given role.
	 * 
	 * @param mixed $input
	 * 
	 * @return bool
	 */
	public static function hasRole($input): bool
	{
		return $input == static::role('name') ? true : false;
	}

	/*

	CUSTOM

	*/

	/**
	 * Return logged in user username.
	 * 
	 * @return mixed
	 */
	public static function username(): mixed
	{
		return isset($_SESSION['user']) ? $_SESSION['user']['username'] : null;
	}
}
