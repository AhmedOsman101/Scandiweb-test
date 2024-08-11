<?php

namespace App;

class Helpers
{
  public static function dd(...$data): void
  {
    foreach ($data as $item) {
      echo "<pre>";
      var_export($item);
      echo "</pre>";
    }
    die;
  }
}
