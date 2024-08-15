<?php

namespace App\Controllers;

use Lib\Helpers;

abstract class Controller
{
  /**
   * Retrieve all resources
   */
    public static function index()
    {
    }

  /**
   * Create new resources
   */
    public static function store()
    {
    }

  /**
   * Delete resources
   */
    public static function destroy()
    {
    }

  /**
   * Renders a view template with the provided data.
   *
   * @param string $view The name of the view template to render.
   * @param array $data An optional array of data to pass to the view template.
   * @return void
   */
    public static function view(string $view, $data = [])
    {
        if (count($data)) {
            extract($data);
        }
        return require_once Helpers::base_path("views/$view.view.php");
    }
}
