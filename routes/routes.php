<?php

use App\Controllers\ProductController;
use App\Router\Router;
use Lib\Helpers;

// create a new router instance
$router = new Router();

$router->get(
  "/",
  [ProductController::class, "index"],
  "product.index"
);

$router->get(
  "/add-product",
  [ProductController::class, "create"],
  "product.create"
);

$router->post(
  "/product",
  [ProductController::class, "store"],
  "product.store"
);

$router->delete(
  "/product",
  [ProductController::class, "destroy"],
  "product.destroy"
);

// register the router to the Helpers class
Helpers::set_router($router);

// listen for routes
$router->watch();
