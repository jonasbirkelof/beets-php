<?php

namespace App\Helpers;

/**
 * View
 * Get view pattern and require page file
 *
 * @param [type] $view
 * @param array $data
 * @return void
 */
function view($pattern, $view = [], $data = []) 
{
	// Check if the view pattern contains a '.' and if so, extract the folder and the file
	if (str_contains($pattern, '.')) {
		// Get the view pattern and explode to get target folder and filename
		$directoryParts = explode('.', $pattern);
		$folder = APP_PATH . '/views/' . $directoryParts[0] . '/';
		$fileName = $directoryParts[1] . '.php';
		
	// If the view pattern does not contain a '.', just pass the pattern as the target filename
	} else {
		$folder = APP_PATH . '/views/';
		$fileName = $pattern . '.php';
	}

	// Require requested file to view
	require_once $folder . $fileName;
}