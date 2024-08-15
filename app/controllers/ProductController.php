<?php

namespace App\Controllers;

use App\Enums\ProductType;
use App\Models\Product;
use App\Sessions\Flash;
use Lib\Helpers;
use Lib\Validator;
use PDOException;

class ProductController extends Controller
{
  /**
   * Renders the view for displaying a list of all products.
   *
   * This method retrieves all products from the database using the `Product::all()` method,
   * and passes them to the 'index' view template to be displayed.
   *
   * @return mixed The rendered view for the 'index' template, which should display the list of products.
   */
  public static function index()
  {
    return static::view('index', [
      'products' => Product::all()
    ]);
  }

  /**
   * Renders the view for creating a new product.
   *
   * This method returns the view for the "add" template, which is likely a form for creating a new product.
   *
   * @return mixed The rendered view for the "add" template.
   */
  public static function create()
  {
    return static::view(
      'add',
      [
        "errors" => Flash::get("errors")
      ]
    );
  }

  public static function store()
  {
    /*
    id
    name,
    sku,
    price,
    type,
    weight,
    size,
    width,
    height,
    length,
    created_at
    */
    extract($_POST);

    $validator = new Validator();

    $validator->string(
      field: "name",
      string: $name,
      min: 3,
      max: 50
    );

    $validator->string(
      field: "sku",
      string: $sku,
      min: 5,
      max: 75
    );

    $validator->float(
      field: "price",
      number: $price,
      min: 0.01,
    );

    $validator->in_enum(
      field: "type",
      value: $type,
      enum: ProductType::class
    );

    $validator->float(
      field: "weight",
      number: $weight ?? null,
      min: 0.01,
      optional: !isset($weight)
    );

    $validator->float(
      field: "size",
      number: $size ?? null,
      min: 0.01,
      optional: !isset($size)
    );

    $validator->int(
      field: "width",
      number: $width ?? null,
      min: 1,
      optional: !isset($width)
    );

    $validator->int(
      field: "height",
      number: $height ?? null,
      min: 1,
      optional: !isset($height)
    );

    $validator->int(
      field: "length",
      number: $length ?? null,
      min: 1,
      optional: !isset($length)
    );

    if ($validator->hasErrors()) {
      Flash::set("errors", $validator->getErrors());
      Helpers::redirect("product.create");
    }

    try {
      Product::create($_POST);
    } catch (PDOException $e) {
      if ($e->getCode() === "23000") {
        Flash::set("errors", "This SKU is already taken");
        Helpers::redirect("product.create");
      } else {
        Flash::set("errors", ['message' => $e->getMessage(), 'code' => $e->getCode()]);
        Helpers::redirect("product.create");
      }
    }
  }

  /**
   * Deletes one or more products based on the provided IDs.
   *
   * This method first checks if any IDs were provided in the request. If not, it returns an error.
   * It then attempts to delete the products with the given IDs using the `Product::destroy()` method.
   * If no products were deleted, it returns a "not found" error.
   * If the deletion is successful, it redirects the user to the "product.index" route.
   * If a PDOException occurs during the deletion, it outputs the error message.
   */
  public static function destroy()
  {

    try {
      // convert the json input to an assoc array
      $ids = json_decode($_REQUEST["_ids"], true);

      // check for empty input
      if (!sizeof($ids)) {
        Helpers::dd("no data passed"); // FIXME: handle empty input
      }

      // delete the selected product
      $query = Product::destroy($ids);

      // if no products was deleted, return an error
      if ($query->rowCount() === 0) {
        // FIXME: not found
        Helpers::dd("not found");
      }

      // redirect on success
      Helpers::redirect("product.index");
    } catch (PDOException $error) {
      // FIXME: handle pdo errors
      Helpers::dd($error->getMessage());
    }
  }
}
