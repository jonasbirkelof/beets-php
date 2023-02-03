<?php

namespace App\Helpers;

function view($pattern, $attributes = [])
{
	extract($attributes);

	require_once PUBLIC_ROOT . 'views/' . $pattern;
}