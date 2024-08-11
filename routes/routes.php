<?php

use App\Controllers\ProductController;
use App\Router\Router;


// init routes array
$routes = [
  "home" => [
    "uri" => "/",
    "action" => [ProductController::class, "index"],
    "method" => "GET"
  ],
  "product.create" => [
    "uri" => "/add-product",
    "action" => [ProductController::class, "create"],
    "method" => "GET"
  ],
  "product.store" => [
    "uri" => "/store-product",
    "action" => [ProductController::class, "store"],
    "method" => "POST"
  ],
  "product.delete" => [
    "uri" => "/delete-product",
    "action" => [ProductController::class, "delete"],
    "method" => "DELETE"
  ],
];


// current URI
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_method = $_SERVER['REQUEST_METHOD'];

// create a new router instance
$router = new Router($routes);

// listen for routes
$router->watch($uri, $request_method);
