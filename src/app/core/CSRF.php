<?php

declare(strict_types=1);

namespace App\Core;

class CSRF
{
	private static $hashedToken;

	private static function createToken(): string
	{
		return bin2hex(random_bytes(24));
	}

	public static function newToken(): void
	{
		$token = static::createToken();
		static::$hashedToken = hash_hmac('sha256', $token, $_ENV['CSRF_SECRET_KEY']);
		$_SESSION['_csrf'] = $token;
	}

	public static function hashedToken(): string
	{
		return static::$hashedToken;
	}

	public static function token(): string
	{
		return $_SESSION['_csrf'];
	}

	public static function validate(): bool
	{
		$formToken = $_POST['_csrf'] ?? "";
		$sessionToken = $_SESSION['_csrf'];
		$secret = $_ENV['CSRF_SECRET_KEY'];

		$hashedToken = hash_hmac('sha256', $sessionToken, $secret);

		return hash_equals($formToken, $hashedToken);
	}
}