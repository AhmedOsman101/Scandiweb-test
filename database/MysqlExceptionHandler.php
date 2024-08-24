<?php

namespace Database;

use PDOException;

/**
 * Class MysqlExceptionHandler
 *
 * Handles various MySQL exceptions by mapping error codes to specific handler methods.
 */
class MysqlExceptionHandler
{
  /**
   * @var array<int, array> $handlersMap Maps MySQL error codes to their respective handler methods.
   */
    protected static array $handlersMap = [
        // exception code => handler method
        1048 => [self::class, 'handleNotNull'],
        1054 => [self::class, 'handleNoColumn'],
        1064 => [self::class, 'handleSyntaxError'],
        1136 => [self::class, 'handleInvalidColumnsCount'],
        1146 => [self::class, 'handleNoTable'],
        1211 => [self::class, 'handleInvalidCollation'],
        1265 => [self::class, 'handleOutOfRange'],
        1366 => [self::class, 'handleInvalidDataType'],
        1406 => [self::class, 'handleLongData'],
    ];

  /**
   * Handles the given PDOException by mapping it to the appropriate handler method.
   *
   * @param PDOException $exception The exception thrown during MySQL query execution.
   * @return array<string, string> The generated error message.
   */
    public static function handle(PDOException $exception)
    {
        $errorInfo = $exception->errorInfo;
        return static::map($errorInfo);
    }

  /**
   * Maps the MySQL error code to a handler method, and calls it if found.
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function map(array $error)
    {
        $ErrorCode = $error[1];
        if (array_key_exists($ErrorCode, self::$handlersMap)) {
            $handler = self::$handlersMap[$ErrorCode];
            return call_user_func_array($handler, [$error]);
        }

        return static::generateErrorMessage(message: "Unknown error");
    }


  /**
   * Handles MySQL error code 1048 (Not null constraint violation).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleNotNull(array $error)
    {
        $column = static::findColumnName($error[2]);

        return static::generateErrorMessage($column, "Null is invalid value");
    }

  /**
   * Handles MySQL error code 1054 (Unknown column).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleNoColumn(array $error)
    {
        $column = static::findColumnName($error[2]);

        return static::generateErrorMessage("Unknown column: '$column'");
    }

  /**
   * Handles MySQL error code 1064 (SQL syntax error).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleSyntaxError(array $error)
    {
        return static::generateErrorMessage(message: "SQL syntax error");
    }

  /**
   * Handles MySQL error code 1136 (Invalid column count).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleInvalidColumnsCount(array $error)
    {
        return static::generateErrorMessage(message: "Column count doesn't match value count");
    }

  /**
   * Handles MySQL error code 1146 (No table).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleNoTable(array $error)
    {
        return static::generateErrorMessage(message: "Table doesn't exist");
    }

  /**
   * Handles MySQL error code 1211 (Invalid collation).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleInvalidCollation(array $error)
    {
        return static::generateErrorMessage(message: "Invalid collation");
    }

  /**
   * Handles MySQL error code 1265 (Out of range value).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleOutOfRange(array $error)
    {
        $column = static::findColumnName($error[2]);

        return static::generateErrorMessage($column, "The value is out of range");
    }

  /**
   * Handles MySQL error code 1366 (Invalid data type).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleInvalidDataType(array $error)
    {
        $column = static::findColumnName($error[2]);

        return static::generateErrorMessage($column, "Invalid data type");
    }

  /**
   * Handles MySQL error code 1406 (Data too long).
   *
   * @param array $error The error info array from the PDOException.
   * @return array<string, string> The generated error message.
   */
    protected static function handleLongData(array $error)
    {
        $column = static::findColumnName($error[2]);

        return static::generateErrorMessage($column, "The data you entered is too long");
    }

  /**
   * Finds the column name from the error message.
   *
   * @param string $errorMessage The error message from the PDOException.
   * @return string|null The extracted column name, or null if not found.
   */
    protected static function findColumnName(string $errorMessage)
    {
        $col = null;

        // Matches the column name enclosed within backticks, single quotes, or double quotes from the error message.
        $columnNamePattern = "/['`\"].+?['`\"]/";

        $str = strstr($errorMessage, "column ");
        $str = str_replace("column ", "", $str);

        if (preg_match_all($columnNamePattern, $str, $matches, PREG_PATTERN_ORDER)) {
            $col = $matches[0][2] ?? $matches[0][0];
            return $col = trim($col, "'`\"");
        }

        return $col;
    }

  /**
   * Generates a consistent error message.
   *
   * @param string|null $column The column name associated with the error (if any).
   * @param string $message The error message to be displayed.
   * @return array<string, string> The generated error message.
   */
    protected static function generateErrorMessage(string|null $column = null, string $message)
    {
        return $column ? [$column => "$message for $column"] : compact("message");
    }
}
