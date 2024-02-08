<?php

namespace App\Models\Authenticate;

use App\Core\Database as DB;

class Permission
{
	/**
	 * Get an array of permissions. Filter and sort result by using 'orderBy = []' and 'where = []'.
	 * 
	 * @param array $args
	 * 
	 * @return array
	 */
	public static function get(array $args = []): array
	{
		$orderClause = DB::orderBy(! empty($args['orderBy']) ? $args['orderBy'] : []);
		$whereClause = DB::where(! empty($args['where']) ? $args['where'] : []);

		$sql = "SELECT id, name, description FROM " . DB_PERMISSIONS . " $whereClause $orderClause";
		$result = DB::query($sql)->fetchAll();

		return $result ?: [];
	}

	/**
	 * Get data of a permission based on its row ID.
	 * 
	 * @param int $permissionId
	 * 
	 * @return array
	 */
	public static function find(int $permissionId): array
	{
		$sql = "SELECT id, name, description FROM " . DB_PERMISSIONS . " WHERE id = :id";
		$result = DB::query($sql, ['id' => $permissionId])->fetch();

		return $result ?: [];
	}

	/**
	 * Get all permissions (and their data) that belongs to a role.
	 * 
	 * @param int $roleId
	 * 
	 * @return array
	 */
	public static function findByRole(int $roleId): array
	{
		$db_permissions = DB_PERMISSIONS;
		$db_permissionsRel = DB_PERMISSIONS_REL;

		$sql = "
			SELECT  
				permission.id as id,
				permission.name as name,
				permission.description as description
			FROM 
				$db_permissionsRel
				LEFT JOIN $db_permissions permission ON permission.id = $db_permissionsRel.permission_id
			WHERE 
				$db_permissionsRel.role_id = :roleId
		";
		$result = DB::query($sql, [
			'roleId' => $roleId
		])->fetchAll();

		return $result ?: [];
	}
}