<?php

namespace App\Controllers;

use App\Models\Product;
use App\Http\Http;
use Lib\Interfaces\Controller;
use App\Http\Response;
use PDOException;

class ProductController implements Controller
{
  public static function index()
  {
    echo Response::Json(
      status_code: Http::OK,
      status: Http::STATUS_MESSAGES[Http::OK],
      data: Product::all()
    );
    exit;
  }

  public static function store()
  {
    echo Response::Json(
      status_code: Http::CREATED,
      status: Http::STATUS_MESSAGES[Http::CREATED],
      data: json_decode(file_get_contents('php://input'), true)
    );
    exit;
  }

  public static function destroy()
  {
    try {
      $body = array_values(json_decode(file_get_contents('php://input'), true));
      $query = Product::destroy($body[0]);

      if ($query->rowCount() === 0) {
        echo Response::Json(
          status_code: Http::NOT_FOUND,
          status: Http::STATUS_MESSAGES[Http::NOT_FOUND],
        );
        exit;
      }

      echo Response::Json(
        status_code: Http::NO_CONTENT,
        status: Http::STATUS_MESSAGES[Http::NO_CONTENT],
      );
      exit;
    } catch (PDOException $error) {
      echo Response::Json(
        status_code: Http::BAD_REQUEST,
        status: Http::STATUS_MESSAGES[Http::BAD_REQUEST],
        errors: array($error->getMessage())
      );
    }
  }
}
