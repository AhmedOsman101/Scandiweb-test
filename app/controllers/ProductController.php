<?php

namespace App\Controllers;

use App\Models\Product;
use Lib\Helpers;
use Lib\Interfaces\Controller;
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
  public static function index(): void
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
  public static function create(): void
  {
    return static::view('add');
  }

  public static function store()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    Helpers::dd($data, $_REQUEST);
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
      if (!sizeof($ids)) Helpers::dd("no data passed"); // FIXME: handle empty input

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
