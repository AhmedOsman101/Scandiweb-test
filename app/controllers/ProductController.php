<?php

namespace App\Controllers;

use App\Enums\ProductType;
use App\Forms\AddProductForm;
use App\Http\Http;
use App\Http\Response;
use App\Models\Product;
use App\Sessions\Flash;
use Database\MysqlExceptionHandler;
use Lib\Helpers;
use PDOException;

class ProductController extends Controller
{
    /**
     * Renders the view for displaying a list of all products.
     *
     * This method retrieves all products from the database using the `Product::all()` method,
     * filters out any null values from the product data, and passes the cleaned product data along with
     * product configuration details and any error messages to the 'index' view template for display.
     *
     * @return mixed The rendered view for the 'index' template.
     */
    public static function index()
    {

        $products = Product::all();

        // filter out null entries to only keep keys that has values
        $products = array_map(
            fn($product) => array_filter(
                $product,
                fn($value) => $value !== null
            ),
            $products
        );

        $productConfigs = [
            ProductType::BOOK->value      => [
                "label"  => "Weight",
                "field"  => "weight",
                "suffix" => "KG",
            ],
            ProductType::DVD->value       => [
                "label"  => "Size",
                "field"  => "size",
                "suffix" => "MB",
            ],
            ProductType::FURNITURE->value => [
                "label"  => "Dimensions",
                "field"  => "dimensions",
                "suffix" => "",
            ],
        ];


        $error = json_encode(Flash::get("error"));

        return static::view(
            view: "index",
            data: compact(
                "products",
                "productConfigs",
                "error",
            )
        );
    }

    /**
     * Renders the view for creating a new product.
     *
     * This method retrieves a list of product types, encodes it into JSON format, and passes it to the 'add' view template,
     * which is likely a form for creating a new product. The view template is rendered with the available product types.
     *
     * @return mixed The rendered view for the 'add' template
     */
    public static function create()
    {
        $types = json_encode(Helpers::enumToAssocArray(ProductType::class));

        return static::view(
            view: 'add',
            data: compact("types")
        );
    }

    /**
     * Handles the storage of a new product.
     *
     * This method reads JSON data from the request body, validates it using the `AddProductForm` class,
     * and attempts to create a new product record in the database.
     * If validation errors are present, it returns a JSON response with the error details and a 400 Bad Request status.
     * If the product creation is successful, it returns a JSON response with a 201 Created status.
     * In case of a database exception, such as a unique constraint violation, it returns an appropriate error message.
     *
     * @return void
     */
    public static function store()
    {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents('php://input'), true);

        $data = array_map(
            function ($item) {
                if (is_numeric($item)) {
                    return round($item, 2);
                }
                return $item;
            },
            $data
        );

        $form = new AddProductForm();

        $form->validate($data);

        if ($form->hasErrors()) {
            Response::json(
                status: Http::STATUS_MESSAGES[Http::BAD_REQUEST],
                statusCode: Http::BAD_REQUEST,
                errors: $form->getErrors()
            );
        }


        try {
            $product = Product::where("sku", $data['sku']);

            if (empty($product)) {
                Product::create($data);

                Response::json(
                    status: Http::STATUS_MESSAGES[Http::CREATED],
                    statusCode: Http::CREATED
                );
            }

            Response::json(
                status: Http::STATUS_MESSAGES[Http::BAD_REQUEST],
                statusCode: Http::BAD_REQUEST,
                errors: [
                    "sku" => "This SKU is already taken",
                ],
            );
        } catch (PDOException $e) {
            $error = MysqlExceptionHandler::handle($e);

            Response::json(
                status: Http::STATUS_MESSAGES[Http::INTERNAL_SERVER_ERROR],
                statusCode: Http::INTERNAL_SERVER_ERROR,
                errors: $error,
            );
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
     *
     * @throws PDOException If a database error occurs during deletion
     */
    public static function destroy()
    {

        try {
            $ids = json_decode($_REQUEST["_ids"], true);

            if (empty($ids)) {
                Flash::set('error', 'No products were selected.');
                Helpers::redirect('product.index');
            }

            $query = Product::destroy($ids);

            //? this handles when two users attempt to delete the same product at the same time.
            if ($query->rowCount() === 0) {
                Flash::set("error", "No products found for the provided IDs.");
            }
        } catch (PDOException $error) {
            Flash::set("error", "An error occurred while deleting products");
        } finally {
            Helpers::redirect("product.index");
        }
    }
}
