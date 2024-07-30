<?php

use App\Controllers\ProductController;

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

$controller = new ProductController();

$routes = [
  '/' => 'HomeController',
  '/add-product' => 'ProductController'
];
