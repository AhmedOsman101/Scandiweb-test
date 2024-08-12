<?php

namespace Lib;

interface HttpClientInterface
{
  public function execute(string $method, string $url, array $options = []): HttpResponseInterface;
}

interface HttpResponseInterface
{
  public function Response(): object;
  public function Json(): string;
  public function StatusCode(): int;
  public function Status(): object;
  public function Data(): object|string;
}

class HttpClient implements HttpClientInterface
{
  private static ?HttpClient $instance = null;
  private $ch;

  private function __construct()
  {
    $this->ch = curl_init();
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function execute(string $method, string $url, array $options = []): HttpResponseInterface
  {
    $allOptions = [
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_RETURNTRANSFER => true,
    ];

    if (!empty($options['headers'])) {
      $allOptions[CURLOPT_HTTPHEADER] = $options['headers'];
    }

    if (!empty($options['return'])) {
      $allOptions[CURLOPT_RETURNTRANSFER] = $options['return'];
    }

    if (!empty($options['data'])) {
      $allOptions[CURLOPT_POSTFIELDS] = json_encode($options['data']);
    }

    curl_setopt_array($this->ch, $allOptions);

    try {
      $response = curl_exec($this->ch);

      $status = [];

      if ($response === false) {
        $status["error"] =  curl_error($this->ch);
      }

      $statusCode = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);

      if (in_array($statusCode, array_keys(Http::STATUS_MESSAGES))) {
        $status["response"]  = Http::STATUS_MESSAGES[$statusCode];
      }

      return new HttpResponse($response, $statusCode, $status);
    } catch (\Throwable $e) {
      throw new \RuntimeException("HTTP request failed: " . $e->getMessage());
    } finally {
      curl_reset($this->ch);
    }
  }

  public function __destruct()
  {
    curl_close($this->ch);
  }
}

class HttpResponse implements HttpResponseInterface
{
  private object $response;

  public function __construct(string $data, int $statusCode, array $status)
  {
    $this->response = (object) [
      'data' => json_decode($data),
      'status' => (object) $status,
      'statusCode' => $statusCode
    ];
  }

  public function Response(): object
  {
    return $this->response;
  }

  public function Json(): string
  {
    return json_encode($this->response);
  }

  public function StatusCode(): int
  {
    return $this->response->statusCode;
  }

  public function Status(): object
  {
    return $this->response->status;
  }

  public function Data(bool $json = false): object|string
  {
    if ($json) {
      return json_encode($this->response->data);
    }

    return $this->response->data;
  }
}

class Http
{
  public const int HTTP_OK = 200;
  public const int HTTP_CREATED = 201;
  public const int HTTP_NO_CONTENT = 204;
  public const int HTTP_BAD_REQUEST = 400;
  public const int HTTP_UNAUTHORIZED = 401;
  public const int HTTP_FORBIDDEN = 403;
  public const int HTTP_NOT_FOUND = 404;
  public const int HTTP_METHOD_NOT_ALLOWED = 405;
  public const int HTTP_INTERNAL_SERVER_ERROR = 500;
  public const int HTTP_SERVICE_UNAVAILABLE = 503;

  public const array STATUS_MESSAGES = [
    self::HTTP_OK                     => 'OK',
    self::HTTP_CREATED                => 'Created',
    self::HTTP_NO_CONTENT             => 'No Content',
    self::HTTP_BAD_REQUEST            => 'Bad Request',
    self::HTTP_UNAUTHORIZED           => 'Unauthorized',
    self::HTTP_FORBIDDEN              => 'Forbidden',
    self::HTTP_NOT_FOUND              => 'Resource Not Found',
    self::HTTP_METHOD_NOT_ALLOWED     => 'Method Not Allowed',
    self::HTTP_INTERNAL_SERVER_ERROR  => 'Internal Server Error',
    self::HTTP_SERVICE_UNAVAILABLE    => 'Service Unavailable',
  ];

  private static array $headers = [
    "Content-type: application/json; charset=UTF-8",
  ];

  private static HttpClientInterface $client;

  private function __construct() {}

  private static function getClient(): HttpClientInterface
  {
    if (!isset(self::$client)) {
      self::$client = HttpClient::getInstance();
    }
    return self::$client;
  }

  public static function request(string $method, string $url, array $data = [], bool $return = true): HttpResponseInterface
  {
    $options = [
      'headers' => self::$headers,
      'data' => $data,
      'return' => $return
    ];

    return self::getClient()->execute($method, $url, $options);
  }

  public static function Get(string $url): HttpResponseInterface
  {
    return self::request('GET', $url);
  }

  public static function Post(string $url, array $data, bool $return = false): HttpResponseInterface
  {
    return self::request(
      'POST',
      $url,
      $data,
      $return
    );
  }

  public static function Put(string $url, array $data, bool $return = false): HttpResponseInterface
  {
    return self::request(
      'PUT',
      $url,
      $data,
      $return
    );
  }

  public static function Patch(string $url, array $data, bool $return = false): HttpResponseInterface
  {
    return self::request(
      'PATCH',
      $url,
      $data,
      $return
    );
  }

  public static function Delete(string $url): HttpResponseInterface
  {
    return self::request('DELETE', $url, return: false);
  }

  public static function setHeaders(array $headers): void
  {
    self::$headers = array_merge(self::$headers, $headers);
  }
}
