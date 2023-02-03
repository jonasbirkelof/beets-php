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
		$sql = "SELECT * FROM users WHERE id = ?";
		// Fetch result
		$result = $db->query($sql, [$id])->fetch();

		// Return result
		return $result ?: [];
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
		$sql = "SELECT * FROM users";
		// Fetch result
		$result = $db->query($sql)->fetchAll();

		// Return result
		return $result ?: [];
	}
}