<?php

namespace App\Models;

class Product 
{
	/**
	 * Get all posts in the $products array
	 *
	 * @return array
	 * 
	 */
	public static function getAll(): array
	{
		// Initiate result
		$result = [];

		// Require data file for the sample array
		require __DIR__ . '/../../config/data.php';

		$result = $productsList;

		return $result;
	}
}