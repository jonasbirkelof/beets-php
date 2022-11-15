<?php

namespace App\Models;

use App\Helpers\Database;

class User 
{
	/**
	 * Get a single user using the $userId.
	 *
	 * @param int|null $id
	 * 
	 * @return array
	 * 
	 */
	public static function get(int $id = null): array
	{
		// Connect to database
		$db = new Database();
		// Create a query
		$query = "SELECT * FROM users WHERE id = ?";
		// Fetch result
		$user = $db->query($query, [$id])->fetch();

		// Return result
		return $user;
	}
	
	/**
	 * Get all posts in the users table
	 *
	 * @return array
	 * 
	 */
	public static function getAll(): array
	{
		// Connect to database
		$db = new Database();
		// Create a query
		$query = "SELECT * FROM users";
		// Fetch result
		$usersList = $db->query($query)->fetchAll();

		// Return result
		return $usersList;
	}
}