<?php

namespace App\Controllers;

use Lib\Helpers;

abstract class Controller
{
  /**
   * Display a listing of the resource.
   */
    public static function index()
    {
    }

  /**
   * Show the form for creating a new resource.
   */
    public static function create()
    {
    }

  /**
   * Store a newly created resource in storage.
   */
    public static function store()
    {
    }

  /**
   * Remove the specified resource from storage.
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
        return require_once Helpers::basePath("views/$view.view.php");
    }
}
