<?php

namespace Router;

use App\Controllers\ProductController;

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

$controller = new ProductController();



class Router
{
  private $controller;
  private $routes;

  public function __construct(array $routes)
  {
    $this->routes = $routes;
    $this->controller;
  }
}
