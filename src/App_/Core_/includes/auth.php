<?php

use App\Core\Authenticate as Auth;

/**
 * 
 * Check if the user is logged in.
 * 
 * @return bool
 */
function auth(): bool
{
	return Auth::check();
}

/**
 * Check if the user is NOT logged in.
 * 
 * @return bool
 */
function guest(): bool
{
	return ! Auth::check();
}

/**
 * Check if the user has the given role.
 * 
 * @param mixed $roleName
 * 
 * @return bool
 */
function role($roleName): bool
{
	return Auth::hasRole($roleName);
}

/**
 * Check if the user has the role of "sysadmin".
 * 
 * @return bool
 */
function sysadmin(): bool
{
	return role('sysadmin');
}

/**
 * Check if the user has the role of "amdin".
 * 
 * @return bool
 */
function admin(): bool
{
	return role('admin');
}

/**
 * Check if the user has the role of "user".
 * 
 * @return bool
 */
function user(): bool
{
	return role('user');
}

/**
 * Check if the logged in user has the given permission (decided by role).
 * 
 * @param mixed $permissionName
 * 
 * @return bool
 */
function permission($permissionName): bool
{
	$userPermissions = Auth::permissions() ?? [];
	$permissions = [];

	foreach ($userPermissions as $p) {
		$permissions[] = $p['name'];
	}

	return in_array($permissionName, $permissions);
}