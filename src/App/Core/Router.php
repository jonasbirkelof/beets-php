<?php

declare(strict_types=1);

namespace App\Core;

use Bramus\Router\Router as BramusRouter;

class Router extends BramusRouter
{
	public function getRequestMethod(): string
    {
        return $_POST['_method'] ?? parent::getRequestMethod();
    }
}