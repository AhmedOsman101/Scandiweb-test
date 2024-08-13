<?php

namespace Lib\Interfaces;

use Lib\Helpers;

abstract class Controller
{
  /**
   * Retrieve all resources
   */
  public static function index() {}

  /**
   * Create new resources
   */
  public static function store() {}

  /**
   * Delete resources
   */
  public static function destroy() {}

  public static function view(string $view, $data = [])
  {
    if (count($data)) extract($data);
    return require_once Helpers::base_path("views/$view.view.php");
  }
}
