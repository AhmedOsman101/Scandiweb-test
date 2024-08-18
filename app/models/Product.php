<?php

namespace App\Models;

/**
 * Product Model Class
 *
 * This class represents the "products" table in the database and provides
 * methods to interact with product records.
 */
class Product extends Model
{
    /**
     * @var string The name of the database table associated with the Product model.
     */
    public const string TABLE = "products";
}
