<?php

namespace App\Controllers;

class ProductController extends Controller
{
  public function index()
  {
    return require_once PARENT_DIRECTORY . '/views/index.view.php';
  }

  public function create()
  {
  }

  public function delete()
  {
  }
}
