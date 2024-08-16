<?php

namespace App\Models;

use Database\Database;

abstract class Model
{
    private static Database $db;
    public const TABLE = "";

    //* Singletons should not be cloned nor instantiated by client.
    protected function __construct() {}

    protected function __clone() {}

    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::TABLE;
        return static::DB()->readQuery($sql);
    }

    public static function find($id): object|bool
    {
        $sql = "SELECT * FROM " . static::TABLE . " WHERE id = :id";

        $result = static::DB()->readQuery($sql, compact($id));
        return $result[0] ?? false;
    }

    public static function where($column, $value, $operator = '='): object|bool
    {
        $sql = "SELECT * FROM " . static::TABLE . " WHERE $column $operator = ?";

        $result = static::DB()->readQuery($sql, [$value]);
        return $result ?? false;
    }

    public static function create(array $data)
    {
        $columns = implode(',', array_keys($data));
        $values = ":" . implode(',:', array_keys($data));

        $sql = "INSERT INTO " . static::TABLE . " ($columns) VALUES ($values)";

        return static::DB()->writeQuery($sql, $data);
    }

    public static function destroy(array $ids)
    {
        $sql = "DELETE FROM ";
        $sql .= static::TABLE;
        $sql .= " WHERE id IN (";
        $sql .= implode(", ", $ids);
        $sql .= ")";

        return static::DB()->writeQuery($sql);
    }

    private static function DB(): Database
    {
        return static::$db ?? static::$db = Database::getInstance();
    }
}
