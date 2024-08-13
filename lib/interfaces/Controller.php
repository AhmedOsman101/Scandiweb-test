<?php

namespace Lib\Interfaces;

interface Controller
{
  /**
   * Retrieve all resources
   */
  public static function index();

  /**
   * Create new resources
   */
  public static function store();

  /**
   * Delete resources
   */
  public static function destroy();
}
