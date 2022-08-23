<?php

namespace App\Models;

class User 
{
	/**
	 * GET
	 * Get selected user data from db
	 *
	 * @param [type] $id
	 * @return void
	 */
	public static function get($id)
	{
		// Require data file for the sample array
		require __DIR__ . '/../../config/data.php';

		// Simulated db query result
		$usersList = $usersList;

		// Loop through all db records from the query and return result
		foreach ($usersList as $user) {			
			// Return record that matches requested user ID
			if ($user['id'] == $id) {
				return $user;
			}
		}
	}
}