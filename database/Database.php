<?php

namespace Database;

use Lib\Env;
use PDO;
use PDOStatement;

/**
 * Database Class
 *
 * This class implements the Singleton pattern to manage database connections
 * and provide methods for executing read and write queries.
 */
class Database
{
    /**
     * @var self|null The singleton instance of the Database class.
     */
    protected static self $instance;

    /**
     * @var PDO|null The PDO instance for database operations.
     */
    protected static PDO $pdo;


    //* Singletons should not be cloned nor instantiated by client.

    /**
     * Constructor
     *
     * Initializes the PDO connection using environment variables.
     */
    protected function __construct()
    {
        $dsn = Env::get('DB_CONNECTION') . ':';

        $dsn .=
            http_build_query(
                data: [
                    "host"     => Env::get('DB_HOSTNAME'),
                    "user"     => Env::get('DB_USERNAME'),
                    "password" => Env::get('DB_PASSWORD'),
                    "dbname"   => Env::get('DB_DATABASE'),
                    "port"     => Env::get('DB_PORT'),
                    "charset"  => Env::get('DB_CHARSET'),
                ],
                arg_separator: ';'
            );

        $this->pdo($dsn);
    }


    protected function __clone()
    {
    }

    /**
     * Returns the singleton instance of the Database class.
     *
     * @return self The singleton instance.
     */
    public static function getInstance(): self
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Initializes and returns the PDO instance.
     *
     * @param string $dsn The Data Source Name (DSN) for the PDO connection.
     * @return PDO The PDO instance.
     */
    protected static function pdo(string $dsn): PDO
    {
        if (!isset(static::$pdo)) {
            static::$pdo = new PDO(
                $dsn,
                options: [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        }

        return static::$pdo;
    }

    /**
     * Executes a read (SELECT) query and returns the results.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters for the query.
     * @return array The fetched results.
     */
    public function readQuery($sql, $params = []): array
    {
        $statement = static::$pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }

    /**
     * Executes a write (INSERT, UPDATE, DELETE) query.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params Optional parameters for the query.
     * @return bool|PDOStatement Returns the PDO statement object or false on failure.
     */
    public function writeQuery($sql, $params = []): bool|PDOStatement
    {
        $statement = static::$pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
}
