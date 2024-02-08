<?php

// Die-and-dump function
require_once 'includes/dd.php';

// Authentication functions
require_once 'includes/auth.php';

// Core functions

function escape($input)
{
	$string = htmlentities($input);
	$string = htmlspecialchars($input);
	$string = strip_tags($input);
	
	return $string; 
}

function view($pattern, $attributes = [])
{
	return \App\Core\App::view($pattern, $attributes);
}

function feedback()
{
	App\Http\Feedback::run();
}

function error($field)
{
    if (! key_exists($field, \App\Core\Session::get('errors', []))) {
        return "";
    }
    
    foreach (\App\Core\Session::get('errors')[$field] as $message) {
        return "<div class=\"invalid-feedback\">$message</div>";
    }
}

function errorStyle($field)
{
    return key_exists($field, \App\Core\Session::get('errors', [])) 
		? "is-invalid" 
		: "";
}

function old($key, $default = '')
{
	return \App\Core\Session::get('old')[$key] ?? $default;
}

function hidden(string $name, string $value)
{
	return "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
}

function method(string $inputMethod)
{
	$method = strtoupper($inputMethod);

	return "<input type=\"hidden\" name=\"_method\" value=\"$method\">";
}

function csrf()
{
	$hashedToken = \App\Core\CSRF::hashedToken();

	return "<input type=\"hidden\" name=\"_csrf\" value=\"$hashedToken\">";
}

function storage($filename)
{
	return APP_URL . '/storage/' . $filename;
}