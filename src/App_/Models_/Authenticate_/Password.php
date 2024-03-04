<?php

namespace App\Models\Authenticate;

use DateTime;
use App\Core\Form;
use App\Models\User;
use DateTimeImmutable;
use App\Core\Database as DB;

class Password
{
	/**
	 * Update a user password.
	 * 
	 * @param string $password
	 * @param string $passwordRepeat
	 * @param int $userId
	 * @param int|null $updatedBy
	 * 
	 * @return bool
	 */
	public static function update(string $password, string $passwordRepeat, int $userId, int $updatedBy = null): bool
	{
		$password = escape($password);
		$passwordRepeat = escape($passwordRepeat);
		$passwordHashed = password_hash($password, PASSWORD_DEFAULT);
		$updatedBy = $updatedBy ?: User::id();

		$Form = new Form();

		$Form->validate('password', $password)->password([
			'error' => "Password length must be between " . PASSWORD_MIN_LENGTH . " and " . PASSWORD_MAX_LENGTH . " characters"
		])->required();
		$Form->validate('password_repeat', $passwordRepeat)->matching($password, [
			'error' => "The passwords does not match"
		])->required();

		if (! $Form->errors()) {
			$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
				password = :password,
				updated_at = :updatedAt,
				updated_by = :updatedBy
				WHERE id = :id
			";
			DB::query($sql, [
				'password' => $passwordHashed, 
				'updatedAt' => date('Y-m-d H:i:s'), 
				'updatedBy' => $updatedBy, 
				'id' => $userId
			]);

			return true;
		}

		$Form->flashErrors();

		return false;
	}

	/**
	 * Check if an email address (user account) exist in the database.
	 * 
	 * @param string $email
	 * 
	 * @return mixed
	 */
	public static function checkEmail(string $email): mixed
	{
		$sql = "SELECT id FROM " . DB_USER_ACCOUNTS . " WHERE email = :email";
		$rowId = DB::query($sql, ['email' => $email])->fetchColumn();

		return $rowId ?: false;
	}

	/**
	 * Get an email address for a given user ID.
	 * 
	 * @param string $userId
	 * 
	 * @return mixed
	 */
	public static function getEmail(string $userId): mixed
	{
		$sql = "SELECT email FROM " . DB_USER_ACCOUNTS . " WHERE id = :id";
		$email = DB::query($sql, ['id' => $userId])->fetchColumn();

		return $email ?: false;
	}

	/**
	 * Get a user ID based on a token.
	 * 
	 * @param string $token
	 * 
	 * @return mixed
	 */
	public static function getUserId(string $token): mixed
	{
		$sql = "SELECT id FROM " . DB_USER_ACCOUNTS . " WHERE password_reset_token = :token";
		$rowId = DB::query($sql, ['token' => $token])->fetchColumn();

		return $rowId ?: false;
	}
	
	public static function generateToken(int $rowId)
	{
		$existingTokens = [];

		// Get all existing tokens and put in an array
		$sql = "SELECT password_reset_token FROM " . DB_USER_ACCOUNTS . " WHERE password_reset_token IS NOT NULL";
		foreach (DB::query($sql)->fetchAll() as $t) {
			$existingTokens[] = $t['password_reset_token'];
		}

		// Loop until a unique token is generated
		while (count($existingTokens) < (count($existingTokens) + 1)) {
			// Generate a token
			$token = bin2hex(random_bytes(16));

			// If the generated token doesn't exists in the db, save it
			if (! in_array($token, $existingTokens)) {
				$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
					password_reset_token = :token, 
					password_reset_token_created_at = :createdAt
					WHERE id = :id
				";
				DB::query($sql, [
					'token' => $token, 
					'createdAt' => date('Y-m-d H:i:s'), 
					'id' => $rowId
				]);

				return $token;
			}
		}	
	}

	public static function checkToken($token): bool
	{
		$sql = "SELECT id, password_reset_token_created_at FROM " . DB_USER_ACCOUNTS . " WHERE password_reset_token = :token";
		$result = DB::query($sql, ['token' => $token])->fetch();

		// Return false if token does not exist
		if (! $result) return false;

		// Get the difference between current time and token created
		$createdTime = new DateTimeImmutable($result['password_reset_token_created_at']);
		$currentTime = new DateTimeImmutable(date("Y-m-d H:i:s"));
		$diffInSeconds = $currentTime->getTimestamp() - $createdTime->getTimestamp();

		// If the token expiration has passed, delete the token and return false
		if ($diffInSeconds > PASSWORD_RESET_TOKEN_EXPIRATION) {
			static::deleteToken($result['id']);
			return false;
		}

		return true;
	}

	public static function expiresAt($token): mixed
	{
		if (! static::checkToken($token)) return false;

		$sql = "SELECT id, password_reset_token_created_at FROM " . DB_USER_ACCOUNTS . " WHERE password_reset_token = :token";
		$result = DB::query($sql, ['token' => $token])->fetch();

		// Add expiration in seconds
		$createdTime = new DateTime($result['password_reset_token_created_at']);
		$createdTime->modify('+' . PASSWORD_RESET_TOKEN_EXPIRATION . ' seconds');
		
		return $createdTime->format("Y-m-d H:i:s");
	}

	public static function deleteToken(int $rowId)
	{
		$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
			password_reset_token = :token,
			password_reset_token_created_at = :createdAt
			WHERE id = :id
		";
		DB::query($sql, [
			'token' => null, 
			'createdAt' => null, 
			'id' => $rowId
		]);
	}

	public static function sendResetEmail(string $toEmail, string $token)
	{
		$to      = $toEmail;
		$subject = APP_NAME . ' - Password Reset';
		$message = '
			<html>
				<body>
					<strong>Password Reset</strong>
					<p>We have sent this email because someone has requested that you password should be changed. Visit the link below to continue.</p>
					<p>If you did not request a password reset, please ignore this email and contact the administrator.</p>
					<p>The link is valid for ' . PASSWORD_RESET_TOKEN_EXPIRATION / 60 . ' minutes.</p>
					<p><a href="' . APP_URL . '/reset-password/new?token=' . $token . '">Reset your password</a></p>
				</body>
			</html>
		';
		$headers = 'From: ' . $_ENV['EMAIL_SENDER'] . "\r\n";

		mail($to, $subject, $message, $headers);
	}

	public static function sendConfirmationEmail(string $toEmail)
	{
		$to      = $toEmail;
		$subject = APP_NAME . ' - Your password has been changed';
		$message = '
			<html>
				<body>
					<strong>Your password has been changed</strong>
					<p>Your password to your account at ' . APP_NAME . ' has been changed.</p>
					<p><a href="' . APP_URL . '/login">Click to log in</a></p>
				</body>
			</html>
		';
		$headers = 'From: ' . $_ENV['EMAIL_SENDER'] . "\r\n";

		mail($to, $subject, $message, $headers);
	}
}