<?php

namespace App\Http;

interface HttpClientInterface
{
  public function execute(string $method, string $url, array $options = []): Response;
}

class Client implements HttpClientInterface
{
  private static ?Client $instance = null;
  private $ch;

  private function __construct()
  {
    $this->ch = curl_init();
  }

  public static function getInstance(): static
  {
    if (static::$instance === null) {
      static::$instance = new static();
    }
    return static::$instance;
  }

  public function execute(string $method, string $url, array $options = []): Response
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

      return new Response($response, $statusCode, $status);
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
