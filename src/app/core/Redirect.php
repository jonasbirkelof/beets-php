<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Session;

class Redirect
{
	private static $targetPath;

	/**
	 * Set the target path for the redirect.
	 * 
	 * @param string $targetPath
	 * 
	 * @return object
	 */
	public static function to(string $targetPath): object
	{
		static::$targetPath = $targetPath;

		return new static();
	}

	/**
	 * Append an attribute to the return method.
	 * 
	 * @param array $attr
	 * 
	 * @return object
	 */
	public function with($key, $value): object
	{
		Session::flash($key, $value);

		return $this;
	}

	/**
	 * This will be executed at the end of the class
	 */
	public function __destruct()
	{	
		header("location: " . static::$targetPath);
		exit();
	}
}