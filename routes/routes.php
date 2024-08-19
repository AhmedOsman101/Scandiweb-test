<?php

use App\Controllers\ProductController;
use App\Router\Router;
use Lib\Helpers;

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
Helpers::setRouter($router);

$router->watch();
