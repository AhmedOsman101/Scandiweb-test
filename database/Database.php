<?php

namespace Database;

use Lib\Env;
use PDO;
use PDOStatement;

class Database
{
    protected static $instance;
    protected static $pdo;


    //* Singletons should not be cloned nor instantiated by client.
    protected function __construct()
    {
        $dsn = Env::get('DB_CONNECTION') . ':';

        $dsn .=
            http_build_query(
                data: [
                    "host"      => Env::get('DB_HOSTNAME'),
                    "user"      => Env::get('DB_USERNAME'),
                    "password"  => Env::get('DB_PASSWORD'),
                    "dbname"    => Env::get('DB_DATABASE'),
                    "port"      => Env::get('DB_PORT'),
                    "charset"   => Env::get('DB_CHARSET'),
                ],
                arg_separator: ';'
            );

        $this->pdo($dsn);
    }


    protected function __clone() {}

    public static function getInstance(): self
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

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

    public function readQuery($sql, $params = [])
    {
        $statement = static::$pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    }

    public function writeQuery($sql, $params = []): bool|PDOStatement
    {
        $statement = static::$pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
}
