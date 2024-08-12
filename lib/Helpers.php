<?php

namespace Lib;

use App\Router\Router;

class Helpers
{

  protected static $router;

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
    return static::$router->get_route($name);
  }

  public static function base_path($path = ''): string
  {
    return PARENT_DIRECTORY . '/' . $path;
  }

  public static function set_router(Router $router): void
  {
    static::$router = $router;
  }
}
