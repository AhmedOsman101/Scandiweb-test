<?php

namespace App\Http;

class Http
{
  public const OK = 200;
  public const CREATED = 201;
  public const NO_CONTENT = 204;
  public const BAD_REQUEST = 400;
  public const UNAUTHORIZED = 401;
  public const FORBIDDEN = 403;
  public const NOT_FOUND = 404;
  public const METHOD_NOT_ALLOWED = 405;
  public const INTERNAL_SERVER_ERROR = 500;
  public const SERVICE_UNAVAILABLE = 503;

  public const STATUS_MESSAGES = [
    self::OK                     => 'OK',
    self::CREATED                => 'Created',
    self::NO_CONTENT             => 'No Content',
    self::BAD_REQUEST            => 'Bad Request',
    self::UNAUTHORIZED           => 'Unauthorized',
    self::FORBIDDEN              => 'Forbidden',
    self::NOT_FOUND              => 'Resource Not Found',
    self::METHOD_NOT_ALLOWED     => 'Method Not Allowed',
    self::INTERNAL_SERVER_ERROR  => 'Internal Server Error',
    self::SERVICE_UNAVAILABLE    => 'Service Unavailable',
  ];

  private static array $headers = [
    "Content-type: application/json; charset=UTF-8",
  ];

  private static Client $client;

  private function __construct() {}

  private static function getClient(): Client
  {
    if (!isset(self::$client)) {
      self::$client = Client::getInstance();
    }
    return self::$client;
  }

  public static function request(
    string $method,
    string $url,
    array $data = [],
    bool $return = true
  ): Response {
    $options = [
      'headers' => self::$headers,
      'data' => $data,
      'return' => $return
    ];

    return self::getClient()->execute($method, $url, $options);
  }

  public static function Get(string $url): Response
  {
    return self::request('GET', $url);
  }

  public static function Post(string $url, array $data, bool $return = false): Response
  {
    return self::request(
      'POST',
      $url,
      $data,
      $return
    );
  }

  public static function Put(string $url, array $data, bool $return = false): Response
  {
    return self::request(
      'PUT',
      $url,
      $data,
      $return
    );
  }

  public static function Patch(string $url, array $data, bool $return = false): Response
  {
    return self::request(
      'PATCH',
      $url,
      $data,
      $return
    );
  }

  public static function Delete(string $url): Response
  {
    return self::request('DELETE', $url, return: false);
  }

  public static function setHeaders(array $headers): void
  {
    self::$headers = array_merge(self::$headers, $headers);
  }
}
