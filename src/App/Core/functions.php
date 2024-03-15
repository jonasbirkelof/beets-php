<?php

// Die-and-dump function
require_once 'includes/dd.php';

// Authentication functions
require_once 'includes/auth.php';

// Core functions

/**
 * Escape HTML and special characters from a string.
 */
function escape($input)
{
	$string = htmlentities($input);
	$string = htmlspecialchars($input);
	$string = strip_tags($input);
	
	return $string; 
}

/**
 * Return a view and pass attributes that will be accessible in the view as an array.
 */
function view($pattern, $attributes = [])
{
	return \App\Core\App::view($pattern, $attributes);
}

/**
 * Execute the Feedback::run() method.
 */
function feedback()
{
	App\Http\Feedback::run();
}

/**
 * Return errors stored in the session and print them using Bootstrap.
 */
function error($field)
{
    if (! key_exists($field, \App\Core\Session::get('errors', []))) {
        return "";
    }
    
    foreach (\App\Core\Session::get('errors')[$field] as $message) {
        return "<div class=\"invalid-feedback\">$message</div>";
    }
}

/**
 * Style an input with Bootstrap if there are errors.
 */
function errorStyle($field)
{
    return key_exists($field, \App\Core\Session::get('errors', [])) 
		? "is-invalid" 
		: "";
}

/**
 * Return the "old" form value for an input from the session.
 */
function old($key, $default = '')
{
	return \App\Core\Session::get('old')[$key] ?? $default;
}

/**
 * Print a hidden input field and set the name and value of it.
 */
function hidden(string $name, string $value)
{
	return "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
}

/**
 * Print a hidden "_method" field to set a custom HTTP request method.
 */
function method(string $inputMethod)
{
	$method = strtoupper($inputMethod);

	return "<input type=\"hidden\" name=\"_method\" value=\"$method\">";
}

/**
 * Print a hidden CSRF field to a form.
 */
function csrf()
{
	$hashedToken = \App\Core\CSRF::hashedToken();

	return "<input type=\"hidden\" name=\"_csrf\" value=\"$hashedToken\">";
}

/**
 * Return a file from the path to the folder "~/storage"
 */
function storage($filename)
{
	return STORAGE . '/' . $filename;
}

/**
 * Return a file from the path to the folder "~/public/assets/images"
 */
function image($fileName) {
	return IMAGES . '/' . $fileName;
}

/**
 * Return a file from the path to the folder "~/public/partials
 */
function partial($fileName, $extension = DEFAULT_FILE_EXTENSION) {
	require PARTIALS . '/' . $fileName . $extension;
}

/**
 * Check the app environment return as bool or string.
 */
function env($environment = null) {
	if (! $environment) {
		return APP_ENV;
	} else {
		return APP_ENV == $environment ? true : false;
	}
}

/**
 * Translate APP_DEBUG into bool.
 */
function debug() {
	switch (APP_DEBUG) {
		case 'true':
			return true;
			break;
		case 'false':
			return false;
			break;
		default:
			return null;
			break;
	}
}