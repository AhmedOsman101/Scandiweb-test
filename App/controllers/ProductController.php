<?php

namespace App\Controllers;

use App\Models\Product;
use App\Http\Http;
use Lib\Helpers;
use Lib\Interfaces\Controller;
use App\Http\Response;
use PDOException;

class ProductController extends Controller
{
  public static function index()
  {
    return static::view('index', [
      'products' => Product::all()
    ]);
  }

  public static function create()
  {
    return static::view('add');
  }

  public static function store()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    Helpers::dd($data);
  }

  public static function destroy()
  {
    try {
      $body = array_values(json_decode(file_get_contents('php://input'), true));
      $query = Product::destroy($body[0]);

      if ($query->rowCount() === 0) {
        // not found

        // echo Response::Json(
        //   status_code: Http::NOT_FOUND,
        //   status: Http::STATUS_MESSAGES[Http::NOT_FOUND],
        // );
        // exit;

      }

      // redirect on success
      Helpers::redirect("product.index");


    } catch (PDOException $error) {
      Helpers::dd($error->getMessage());
      // echo Response::Json(
      //   status_code: Http::BAD_REQUEST,
      //   status: Http::STATUS_MESSAGES[Http::BAD_REQUEST],
      //   errors: [$error->getMessage()]
      // );
    }
  }
}
