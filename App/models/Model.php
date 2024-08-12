<?php

namespace App\Models;

use Database\Database;

abstract class Model
{

  private static Database $db;

  public static function all(): array
  {
    $sql = "SELECT * FROM " . static::table();
    return self::DB()->readQuery($sql);
  }

  public static function find($id): object|bool
  {
    $sql = "SELECT * FROM " . static::table() . " WHERE id = :id";
    $result = self::DB()->readQuery($sql, compact($id));
    return $result[0] ?? false;
  }

  public static function where($column, $operator = '=', $value): object|bool
  {
    $sql = "SELECT * FROM " . static::table() . " WHERE $column $operator = ?";

    $result = self::DB()->readQuery($sql, [$value]);
    return $result[0] ?? false;
  }

  private static function DB(): Database
  {
    return self::$db ?? self::$db = Database::getInstance();
  }

  private static function table(): void {}
}
