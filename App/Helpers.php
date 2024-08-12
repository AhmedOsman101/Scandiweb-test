<?php

namespace App;

class Helpers
{
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
    $config = require PARENT_DIRECTORY . '/config/config.php';
    return $config['routes'][$name]['uri'] ?? null;
  }
}
