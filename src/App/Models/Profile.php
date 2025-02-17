<?php

namespace App\Models;

use App\Core\Authenticate as Auth;
use App\Core\Form;
use App\Core\Session;
use App\Core\Database as DB;

class Profile
{

	/**
	 * Get user data for logged in user.
	 */
	public static function find()
	{
		return User::find(User::id());
	}

	/**
	 * Get user data for logged in user. If there is no result, return a 404-page.
	 */
	public static function findOrFail()
	{
		return User::findOrFail(User::id());
	}

	/**
	 * Update user profile.
	 * 
	 * @param array $formData
	 * 
	 * @return bool
	 */
	public static function update(array $formData): bool
	{
		$firstName = escape($formData['first_name']);
		$lastName = escape($formData['last_name']);
		$email = escape($formData['email']);
		$phone = escape($formData['phone']);
		
		$Form = new Form();
		
		$Form->validate('first_name', $firstName)->name()->required();
		$Form->validate('last_name', $lastName)->name()->required();
		$Form->validate('email', $email)->email()->unique('email', DB_USER_ACCOUNTS, [
			'ignore' => User::id(), 
			'error' => 'The email is already in use'
		])->required();
		$Form->validate('phone', $phone)->lengthMax(17)->numeric();

		if (! $Form->errors()) {
			$sql = "UPDATE " . DB_USER_ACCOUNTS . " SET 
				first_name = :firstName, 
				last_name = :lastName, 
				email = :email, 
				phone = :phone, 
				updated_at = :updatedAt,
				updated_by = :updatedBy 
				WHERE id = :id
			";
			DB::query($sql, [
				'firstName' => $firstName,
				'lastName' => $lastName,
				'email' => $email,
				'phone' => $phone,
				'updatedAt' => date('Y-m-d H:i:s'), 
				'updatedBy' => User::id(), 
				'id' => User::id()
			]);

			// Update session values
			Auth::set('firstName', $firstName);
			Auth::set('lastName', $lastName);
			Auth::set('fullName', $firstName . ' ' . $lastName);
			Auth::set('initials', substr($firstName, 0, 1) . substr($lastName, 0, 1));
			Auth::set('email', $email);
			Auth::set('phone', $phone);

			return true;
		}

		$Form->flashErrors();

		Session::flashOld([
			'first_name' => $firstName,
			'last_name' => $lastName,
			'email' => $email,
			'phone' => $phone
		]);

		return false;
	}
}