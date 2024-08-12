<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
  public static function index()
  {
    $products = Product::all();

    return self::view('index', [
      'products' => $products
    ]);
  }

  public static function create()
  {
    return self::view('add');
  }

  public static function destroy() {}
}
