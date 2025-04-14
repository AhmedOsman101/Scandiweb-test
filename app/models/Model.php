<?php

namespace App\Models;

use Database\Database;
use PDOStatement;

/**
 * Abstract base class for interacting with database tables.
 *
 * This class provides common methods for CRUD operations on database tables.
 * It uses a singleton pattern for the Database instance to ensure a single
 * connection to the database throughout the application.
 */
abstract class Model
{
    /**
     * @var Database The database instance used for querying.
     */
    private static Database $db;

    /**
     * @var string The name of the database table associated with the model.
     * This constant should be overridden in subclasses.
     */
    public const string TABLE = "";

    //* Singletons should not be cloned nor instantiated by client.
    protected function __construct() {}

    protected function __clone() {}

    /**
     * Retrieves all records from the database table associated with the model.
     *
     * @return array An array of records from the table.
     */
    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::TABLE;
        return static::DB()->readQuery($sql);
    }

    /**
     * Finds a record by its ID.
     *
     * @param mixed $id The ID of the record to find.
     * @return array|null The found record as an associative array, or null if not found.
     */
    public static function find($id): array|null
    {
        $result = static::where(
            column: "id",
            value: $id,
            operator: "="
        );

        return $result[0] ?? null;
    }

    /**
     * Finds records that match a given condition.
     *
     * @param string $column The column to search.
     * @param mixed  $value  The value to match.
     * @param string $operator The operator to use in the condition (default: '=').
     * @return array|null An array of matching records, or false if no records match.
     */
    public static function where($column, $value, $operator = '='): array|null
    {
        $sql = "SELECT * FROM " . static::TABLE . " WHERE $column $operator ?";

        $result = static::DB()->readQuery($sql, [$value]);
        return $result ?? null;
    }

    /**
     * Creates a new record in the database table.
     *
     * @param array $data An associative array of column names and values to insert.
     * @return bool|PDOStatement The ID of the newly created record, or false on failure.
     */
    public static function create(array $data): bool|PDOStatement
    {
        $columns = implode(',', array_keys($data));
        $values = ":" . implode(',:', array_keys($data));

        $sql = "INSERT INTO " . static::TABLE . " ($columns) VALUES ($values)";

        return static::DB()->writeQuery($sql, $data);
    }

    /**
     * Deletes records from the database table.
     *
     * @param array $ids An array of IDs of records to delete.
     * @return bool|PDOStatement The query on success, false on failure.
     */
    public static function destroy(array $ids): bool|PDOStatement
    {
        $sql = "DELETE FROM ";
        $sql .= static::TABLE;
        $sql .= " WHERE id IN (";
        $sql .= implode(", ", $ids);
        $sql .= ")";

        return static::DB()->writeQuery($sql);
    }

    /**
     * Gets the database instance.
     *
     * @return Database The database instance.
     */
    private static function DB(): Database
    {
        return static::$db ?? static::$db = Database::getInstance();
    }
}
