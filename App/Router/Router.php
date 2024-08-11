<?php

namespace App\Router;

class Router
{
  private $routes;

  public function __construct(array $routes)
  {
    $this->routes = $routes;
  }

  public function watch(string $uri, string $method)
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $method) {
        call_user_func($route['action']);
      }
    }
  }
}
