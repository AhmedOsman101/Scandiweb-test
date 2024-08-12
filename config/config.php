<?php

use App\Controllers\ProductController;

return [
  "routes" => [
    "product.index" => [
      "uri" => "/",
      "action" => [ProductController::class, "index"],
      "method" => "GET"
    ],
    "product.create" => [
      "uri" => "/add-product",
      "action" => [ProductController::class, "create"],
      "method" => "GET"
    ],
    "product.store" => [
      "uri" => "/store-product",
      "action" => [ProductController::class, "store"],
      "method" => "POST"
    ],
    "product.delete" => [
      "uri" => "/delete-product",
      "action" => [ProductController::class, "delete"],
      "method" => "DELETE"
    ],
  ]
];
