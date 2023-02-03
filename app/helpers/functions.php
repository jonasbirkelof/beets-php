<?php

require_once 'functions.dd.php'; // Require the die-and-dump function

function abort($code = 404)
{
    http_response_code($code);

    require PUBLIC_ROOT . "views/{$code}.php";

    die();
}

function setActiveNavItem($input) {
    $activeUri = $_SERVER['REQUEST_URI'];

    return $activeUri == $input ? 'active' : null;
}