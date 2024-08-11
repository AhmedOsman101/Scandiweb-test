<?php

namespace App\Controllers;

abstract class Controller
{
  /**
   * Retrieve all resources
   */
  public static function index() {}

  /**
   * Display a form to create new resources
   */
  public static function create() {}

  /**
   * Create new resources
   */
  public static function store() {}

  /**
   * Delete resources
   */
  public static function delete() {}

  protected static function view(string $view)
  {
    return require_once PARENT_DIRECTORY . "/views/$view.view.php";
  }
}
