<?php

namespace App\Models;

class App
{
	/**
	 * Set Active Nav Item
	 * If the current URI matches the inserted target URI, then return the 'active' class.
	 *
	 * @param [type] $input
	 * @return void
	 */
	public static function setActiveNavItem($input) {
		$activeUri = $_SERVER['REQUEST_URI'];

		return $activeUri == $input ? 'active' : null;
	}
}