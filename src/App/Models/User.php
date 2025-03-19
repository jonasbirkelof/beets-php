<?php

namespace App\Models;

use App\Core\App;
use App\Core\Form;
use App\Core\Session;
use App\Core\Database as DB;
use App\Models\Authenticate\Role;
use App\Core\Authenticate as Auth;
use App\Models\Authenticate\Password;
use App\Models\Authenticate\Permission;

class User
{
	/**
	 * Get user data for a given user ID.
	 * 
	 * @param int $id
	 * 
	 * @return array
	 */
	public static function find(int $id): array
	{
		$sql = "SELECT id, first_name, last_name, email, phone, image, password_reset_token, password_reset_token_created_at, role_id, status, last_login, created_at, created_by, updated_at, updated_by FROM " . DB_USER_ACCOUNTS . " WHERE id = :id";
		$result = DB::query($sql, ['id' => $id])->fetch();

		if (! $result) return [];

		$user = array_merge($result, [
			'full_name' => $result['first_name'] . " " . $result['last_name'],
			'initials' => static::makeInitials($result['first_name'], $result['last_name']),
			'role' => Role::find($result['role_id']),
			'password_reset_token_expire_at' => Password::expiresAt($result['password_reset_token'])
		]);

		return $user ?: [];
	}


	/**
	 * Get user data for a given user ID. If there is no result, return a 404-page.
	 * 
	 * @param int $id
	 * 
	 * @return mixed
	 */
	public static function findOrFail(int $id): mixed
	{
		$result = static::find($id);

		if (! $result) {
			App::abort();
		}

		return $result;
	}

	/**
	 * Get an array of users. Filter and sort result by using 'orderBy = []' and 'where = []'.
	 * 
	 * @param array $args
	 * 
	 * @return array
	 */
	public static function get(array $args = []): array
	{
		$orderClause = DB::orderBy(! empty($args['orderBy']) ? $args['orderBy'] : []);
		$whereClause = DB::where(! empty($args['where']) ? $args['where'] : []);

		$sql = "SELECT id, first_name, last_name, email, phone, image, password_reset_token, password_reset_token_created_at, role_id, status, last_login, created_at, created_by, updated_at, updated_by FROM " . DB_USER_ACCOUNTS . " $whereClause $orderClause";
		$result = DB::query($sql)->fetchAll();
		
		if (! $result) return [];

		foreach ($result as $user) {
			$users[] = array_merge($user, [
				'full_name' => $user['first_name'] . " " . $user['last_name'],
				'initials' => static::makeInitials($user['first_name'], $user['last_name']),
				'role' => Role::find($user['role_id']),
				'password_reset' => Password::checkToken($user['password_reset_token'])
			]);
		}

		return $users ?: [];
	}

	/**
	 * Create a user account
	 * 
	 * @param array $formData
	 * 
	 * @return bool
	 */
	public static function store(array $formData): bool
	{
		$firstName = escape($formData['first_name']);
		$lastName = escape($formData['last_name']);
		$email = escape($formData['email']);
		$phone = escape($formData['phone']);
		$image = null;
		$status = isset($formData['status']) ? filter_var($formData['status'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : 0;
		$role = escape($formData['role']);
		$password = escape($formData['password']);
		$passwordRepeat = escape($formData['password_repeat']);
		$passwordHashed = password_hash($password, PASSWORD_DEFAULT);
		$lastLogin = null;

		$Form = new Form();

		$Form->validate('first_name', $firstName)->name()->required();
		$Form->validate('last_name', $lastName)->name()->required();
		$Form->validate('email', $email)->email()->unique('email', DB_USER_ACCOUNTS, [
			'error' => 'The mail is already in use'
		])->required();		
		$Form->validate('phone', $phone)->lengthMax(17)->numeric();
		$Form->validate('role', $role)->required();
		$Form->validate('password', $password)->password()->required();
		$Form->validate('password_repeat', $passwordRepeat)->matching($password, [
			'error' => 'The passwords does not match'
		])->required();

		if (! $Form->errors()) {
			$sql = "INSERT INTO " . DB_USER_ACCOUNTS . " 
				(first_name, last_name, email, phone, image, password, role_id, status, last_login, created_by) 
				VALUES (:firstName, :lastName, :email, :phone, :image, :password, :roleId, :status, :lastLogin, :createdBy)
			";
			DB::query($sql, [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'phone' => $phone,
				'image' => $image,
				'password' => $passwordHashed,
				'lastLogin' => $lastLogin,
				'roleId' => $role,
				'status' => $status,
				'createdBy' => static::id()
			]);
		}

		$Form->flashErrors();

		Session::flashOld([
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'image' => $image,
			'role' => $role,
			'status' => $status ? 1 : 0
		]);

		Session::flash('newUserId', DB::$lastInsertId);

		return empty($Form->errors());	
	}

	/**
	 * Update a user account.
	 * 
	 * @param array $formData
	 * @param int $userId
	 * 
	 * @return bool
	 */
	public static function update(array $formData, int $userId): bool
	{
		$firstName = escape($formData['first_name']);
		$lastName = escape($formData['last_name']);
		$email = escape($formData['email']);
		$phone = escape($formData['phone']);
		$role = escape($formData['role']);
		$status = isset($formData['status']) ? filter_var($formData['status'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) : 0;
		
		$Form = new Form();
		
		$Form->validate('first_name', $firstName)->name()->required();
		$Form->validate('last_name', $lastName)->name()->required();
		$Form->validate('email', $email)->email()->unique('email', DB_USER_ACCOUNTS, [
			'ignore' => $userId, 
			'error' => 'The email is already in use'
		])->required();
		$Form->validate('phone', $phone)->lengthMax(17)->numeric();
		$Form->validate('role', $role)->required();

		if (! $Form->errors()) {
			$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
				first_name = :firstName, 
				last_name = :lastName, 
				email = :email, 
				phone = :phone, 
				role_id = :roleId, 
				status = :status, 
				updated_at = :updatedAt,
				updated_by = :updatedBy 
				WHERE id = :id
			";
			DB::query($sql, [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'phone' => $phone,
				'roleId' => $role,
				'status' => $status,
				'updatedAt' => date('Y-m-d H:i:s'),
				'updatedBy' => static::id(),
				'id' => $userId,
			]);

			return true;
		}

		$Form->flashErrors();

		Session::flashOld([
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone,
			'role' => $role,
			'status' => $status ? 1 : 0
		]);

		return false;
	}
	
	/**
	 * Delete the user by removing its row in the database and the profile image.
	 * 
	 * @param int $userId
	 * 
	 * @return bool
	 */
	public static function destroy(int $userId): bool
	{
		// Delete image if any
		if (static::image($userId)) static::deleteImage($userId);

		// Delete user
		$sql = "DELETE FROM " . DB_USER_ACCOUNTS . " WHERE id = :id";
		DB::query($sql, ['id' => $userId]);

		return true;
	}

	/**
	 * Delete user profile image by removing the file and updating the database.
	 * 
	 * @param int $userId
	 * 
	 * @return bool
	 */
	public static function deleteImage(int $userId): bool
	{
		// Delete old image
		if (unlink(ROOT . STORAGE . '/' . static::image($userId))) {
			// Update profile
			$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
				image = :image,
				updated_at = :updatedAt,
				updated_by = :updatedBy
				WHERE id = :id
			";
			DB::query($sql, [
				'image' => null, 
				'updatedAt' => date('Y-m-d H:i:s'), 
				'updatedBy' => User::id(), 
				'id' => $userId
			]);

			// Update session values if user is logged in
			if ($userId === Auth::id()) Auth::set('image', null);

			return true;
		}

		return false;
	}

	/**
	 * Update user profile image
	 * 
	 * @param int $userId
	 * 
	 * @return bool
	 */
	public static function updateImage(int $userId): bool
	{
		$newImageName = profileImageName($userId);

		// Delete old image if any
		if (static::image($userId)) static::deleteImage($userId);

		// Create the storage folder if it does not exist
		if (! file_exists(ROOT . STORAGE) && ! is_dir(ROOT . STORAGE)) {
			mkdir(ROOT . STORAGE);
		}
		
		if (move_uploaded_file($_FILES['image']['tmp_name'], ROOT . STORAGE . '/' . $newImageName)) {
			// Update profilew
			$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET image = :image WHERE id = :id";
			DB::query($sql, ['image' => $newImageName, 'id' => $userId]);

			// Update session values if user is logged in
			if ($userId === Auth::id()) Auth::set('image', $newImageName);

			return true;
        }
        
		return false;
	}

	/**
	 * Return logged in user data array.
	 * 
	 * @return object
	 */
	public static function session(): object
	{
		return Auth::user();
	}

	/**
	 * Return the user ID for the logged in user.
	 * 
	 * @return int
	 */
	public static function id(): int
	{
		return Auth::id();
	}

	/**
	 * Pass a user ID to return the first name for that user. Omit the user ID to return the first name for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function firstName(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::firstName();

		$sql = "SELECT first_name FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetchColumn();

		return $result ?: false;
	}

	/**
	 * Pass a user ID to return the last name for that user. Omit the user ID to return the last name for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function lastName(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::lastName();

		$sql = "SELECT last_name FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetchColumn();

		return $result ?: false;
	}

	/**
	 * Pass a user ID to return the fulll name for that user. Omit the user ID to return the full name for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function fullName(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::fullName();

		$sql = "SELECT first_name, last_name FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetch();

		return $result ? $result['first_name'] . ' ' . $result['last_name'] : false;
	}

	/**
	 * Create initials for a user.
	 * 
	 * @param string $firstName
	 * @param string $lastName
	 * 
	 * @return string
	 */
	public static function makeInitials(string $firstName, string $lastName): string
	{
		return mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1);
	}

	/**
	 * Pass a user ID to return the initials for that user. Omit the user ID to return the initials for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return string
	 */
	public static function initials(int|null $userId = null): string
	{
		if (! $userId) return Auth::initials();
		if (! static::find($userId)) return false;

		return static::makeInitials(static::firstName($userId), static::lastName($userId));
	}

	/**
	 * Pass a user ID to return the profile image name for that user. Omit the user ID to return the profile image name for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function image(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::image();

		$sql = "SELECT image FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetchColumn();

		return $result ?: false;
	}

	/**
	 * Pass a user ID to return the role for that user. Omit the user ID to return the role for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function role(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::role();

		$sql = "SELECT role_id FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetchColumn();

		return Role::find($result) ?: false;
	}

	/**
	 * Pass a user ID to return the permissions for that user. Omit the user ID to return the permissions for the logged in user.
	 * 
	 * @param int|null $userId
	 * 
	 * @return mixed
	 */
	public static function permissions(int|null $userId = null): mixed
	{
		if (! $userId) return Auth::permissions();

		$sql = "SELECT role_id FROM " . DB_USER_ACCOUNTS . " WHERE id = :userId";
		$result = DB::query($sql, ['userId' => $userId])->fetchColumn();

		return Permission::findByRole($result) ?: false;
	}
}