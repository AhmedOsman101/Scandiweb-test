<?php

namespace Database;

use Lib\Env;
use PDO;

class Database
{
  protected static $instance;
  protected static $pdo;


  protected function __construct()
  {
    /*
    $dsn = Env::get('DB_CONNECTION') . ':';

    $dsn .=
      http_build_query(
        data: [
          "host" => Env::get('DB_HOST'),
          "user" => Env::get('DB_USERNAME'),
          "password" => Env::get('DB_PASSWORD'),
          "dbname" => Env::get('DB_DATABASE'),
          "charset" => Env::get('DB_CHARSET'),
          "port" => Env::get('DB_PORT'),
        ],
        arg_separator: ';'
      );

    $this->pdo($dsn);
    */
    
    $this->pdo("sqlite:" . PARENT_DIRECTORY . "/database/database.sqlite");
  }

  public static function getInstance(): self
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  protected static function pdo(string $dsn): PDO
  {
    if (!isset(self::$pdo)) {
      self::$pdo = new PDO($dsn, options: [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    }

    return self::$pdo;
  }

  public function readQuery($sql, $params = [])
  {
    $statement = self::$pdo->prepare($sql);
    $statement->execute($params);

    return $statement->fetchAll();
  }

  public function writeQuery($sql, $params = []): bool
  {
    $statement = $this->pdo->prepare($sql);
    return $statement->execute($params);
  }
}
