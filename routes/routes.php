<?php

use App\Controllers\ProductController;
use App\Router\Router;
use Lib\Helpers;

// create a new router instance
$router = new Router();

$router->get(
  "/products",
  [ProductController::class, "index"],
  "product.index"
);

$router->post(
  "/products",
  [ProductController::class, "store"],
  "product.store"
);

$router->delete(
  "/products",
  [ProductController::class, "destroy"],
  "product.destroy"
);

$router->options('/products', function () {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");
  http_response_code(204);
  exit();
});

// register the router to the Helpers class
Helpers::set_router($router);

// listen for routes
$router->watch();
