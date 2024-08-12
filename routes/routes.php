<?php

use App\Router\Router;

// init routes array
$routes = $config['routes'];


// current URI
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_method = $_SERVER['REQUEST_METHOD'];

// create a new router instance
$router = new Router($routes);

// listen for routes
$router->watch($uri, $request_method);
