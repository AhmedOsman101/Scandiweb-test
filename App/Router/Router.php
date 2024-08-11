<?php

namespace App\Router;

class Router
{
  private $routes;

  public function __construct(array $routes)
  {
    $this->routes = $routes;
  }

  public static function watch($uri)
  {
    // code
  }
}
