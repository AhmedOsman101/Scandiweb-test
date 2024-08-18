<?php

namespace App\Enums;

/**
 * Enum representing different product types.
 *
 * This enum defines the possible types of products, such as DVD, BOOK, and FURNITURE.
 */
enum ProductType: string
{
    case DVD = "DVD";
    case BOOK = "BOOK";
    case FURNITURE = "FURNITURE";
}
