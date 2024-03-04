<?php

declare(strict_types=1);

namespace App\Core;

class Session
{
	/**
	 * Check if a key exists in the session and returns a bool. The has() method uses the get() method to search the whole session.
	 * 
	 * @example Session.php echo Session::has("keyName"); // true/false
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public static function has($key): bool
	{
		return (bool) static::get($key);
	}
	
	/**
	 * Put a custom key into the session
	 * 
	 * @example Session.php Session::put("myKey", "myValue"); // $_SESSION["myKey"] = "myValue"
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public static function put($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Get a key from the session. The given key is first checked if it exists in the "_flash" array. If not, it is check if it is a primary key ($_SESSION[$key]). If not, return an optional fallback value that i null by default.
	 *
	 * @example Session.php echo Session::get("myFlashKey"); // $_SESSION["_flash"]["myFlashKey"]
	 * @example Session.php echo Session::get("myKey"); // $_SESSION["myKey"]
	 * @example Session.php echo Session::get("unknownKey"); // null
	 *  
	 * @param mixed $key
	 * @param null $default
	 * 
	 * @return mixed
	 */
	public static function get($key, $default = null): mixed
	{
		return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
	}

	/**
	 * Set a flash message to the session. The flash message is automaticlly unset at the end of page load (~/public/index.php). The key can be set to anything, but "message" is common.
	 * 
	 * @example Session.php Session::flash("message", "myMessage");
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public static function flash($key, $value): void
	{
		$_SESSION['_flash'][$key] = $value;
	}

	/**
	 * Unset the "_flash" session.
	 * 
	 * @example Session.php Session::unflash();
	 * 
	 * @return void
	 */
	public static function unflash(): void
	{
		unset($_SESSION['_flash']);
	}

	/**
	 * Empty the whole session (set it to an empty array). If a key is provided, that key will be unset.
	 * 
	 * @example Session.php Session::flush(); // $_SESSION = [];
	 * @example Session.php Session::flush("myKey"); // unset($_SESSION["myKey"]);
	 * 
	 * @return void
	 */
	public static function flush($key = null): void
	{
		if ($key) {
			unset($_SESSION[$key]);
		} else {
			$_SESSION = [];
		}
	}

	/**
	 * Destroy the session. This flushes the session (sets it to an empty array), destroys the session (session_destroy()) and resets the cookie parameters.
	 *
	 * @example Session.php Session::destroy();
	 *  
	 * @return void
	 */
	public static function destroy(): void
	{
		static::flush();

		session_destroy();

		$params = session_get_cookie_params();
		setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
}