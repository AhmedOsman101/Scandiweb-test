<?php

use App\Router\Router;


// init routes array
$routes = [
  "home" => [
    "uri" => "/",
    "action" => ["ProductController", "index"],
    "method" => "GET"
  ],
  "product.create" => [
    "uri" => "/add-product",
    "action" => ["ProductController", "create"],
    "method" => "GET"
  ],
  "product.store" => [
    "uri" => "/add-product",
    "action" => ["ProductController", "store"],
    "method" => "POST"
  ],
];


// current URI
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_method = $_SERVER['REQUEST_METHOD'];

// create a new router instance
$router = new Router($routes);

// listen for routes
$router->watch($uri, $request_method);
