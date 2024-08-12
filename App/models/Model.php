<?php

namespace App\Models;

use Database\Database;

abstract class Model
{

  private static Database $db;
  public const string TABLE = "";

  public static function all(): array
  {
    $sql = "SELECT * FROM " . static::TABLE;
    return self::DB()->readQuery($sql);
  }

  public static function find($id): object|bool
  {
    $sql = "SELECT * FROM " . static::TABLE . " WHERE id = :id";

    $result = self::DB()->readQuery($sql, compact($id));
    return $result[0] ?? false;
  }

  public static function where($column, $value, $operator = '='): object|bool
  {
    $sql = "SELECT * FROM " . static::TABLE . " WHERE $column $operator = ?";

    $result = self::DB()->readQuery($sql, [$value]);
    return $result ?? false;
  }

  public static function create(array $data)
  {
    $columns = implode(',', array_keys($data));
    $values = ":" . implode(',:', array_keys($data));

    $sql = "INSERT INTO " . static::TABLE . " ($columns) VALUES ($values)";

    return self::DB()->writeQuery($sql, $data);
  }

  public static function destroy(array $ids)
  {
    $sql = "DELETE FROM ";
    $sql .= static::TABLE;
    $sql .= " WHERE id IN (";
    $sql .= implode(", ", $ids);
    $sql .= ")";

    return self::DB()->writeQuery($sql);
  }

  private static function DB(): Database
  {
    return self::$db ?? self::$db = Database::getInstance();
  }
}
