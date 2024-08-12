<?php

namespace App\Models;



class Product extends Model
{
  public static function table(): string
  {
    return 'products';
  }
}
