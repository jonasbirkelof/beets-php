<?php

namespace App\Models\Authenticate;

use App\Core\Database as DB;

class Role
{
	/**
	 * Get an array of roles. Filter and sort result by using 'orderBy = []' and 'where = []'.
	 * 
	 * @param array $args
	 * 
	 * @return array
	 */
	public static function get(array $args = []): array
	{
		$orderClause = DB::orderBy(! empty($args['orderBy']) ? $args['orderBy'] : []);
		$whereClause = DB::where(! empty($args['where']) ? $args['where'] : []);

		$sql = "SELECT id, name, long_name, description FROM " . DB_ROLES . " $whereClause $orderClause";
		$result = DB::query($sql)->fetchAll();

		return $result ?: [];
	}

	/**
	 * Get data of a role based on its row ID.
	 * 
	 * @param int $roleId
	 * 
	 * @return array
	 */
	public static function find(int $roleId): array
	{
		$sql = "SELECT id, name, long_name, description FROM " . DB_ROLES . " WHERE id = :id";
		$result = DB::query($sql, ['id' => $roleId])->fetch();

		return $result ?: [];
	}
}