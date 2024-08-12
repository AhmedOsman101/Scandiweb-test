<?php

namespace Lib;

use App\Router\Router;

class Helpers
{

  protected static $routes;

  public static function dd(...$data): void
  {
    self::dump(...$data);
    die;
  }

  public static function dump(...$data): void
  {
    foreach ($data as $item) {
      echo "<pre>";
      var_export($item);
      echo "</pre>";
    }
  }

  public static function route(string $name): string|null
  {
    return self::$routes[$name]['uri'] ?? null;
  }

  public static function base_path($path = ''): string
  {
    return PARENT_DIRECTORY . '/' . $path;
  }

  public static function set_routes(Router $router): void
  {
    static::$routes = $router->routes;
  }
}
