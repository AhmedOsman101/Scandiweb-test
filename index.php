<?php

use Router\Router;

declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';

// bootstrap the application
require_once __DIR__ . "/bootstrap/bootstrap.php";


$routes = [
  '/' => $controller->index(),
  '/add-product' => 'ProductController'
];

$router = new Router($routes);
