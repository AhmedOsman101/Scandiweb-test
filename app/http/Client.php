<?php

namespace App\Http;

use CurlHandle;

/**
 * Singleton HTTP client for making HTTP requests using cURL.
 *
 * This class provides a singleton instance to manage HTTP requests and responses via cURL.
 * It handles various HTTP methods and manages request options.
 */
class Client
{
    /**
     * @var Client|null Singleton instance of the Client class.
     */
    private static ?Client $instance = null;

    /**
     * @var CurlHandle cURL handle for making HTTP requests.
     */
    private CurlHandle $ch;

    //* Singletons should not be cloned nor instantiated by client.
    private function __construct()
    {
        $this->ch = curl_init();
    }

    private function __clone()
    {
    }

    /**
     * Gets the singleton instance of the Client class.
     *
     * @return static The singleton instance of the Client class.
     */
    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Executes an HTTP request using the specified method and options.
     *
     * @param string $method The HTTP method (e.g., GET, POST, PUT, PATCH, DELETE).
     * @param string $url The URL for the request.
     * @param array $options Optional request options including headers, data, and whether to return the response.
     *
     * @return Response The HTTP response.
     *
     * @throws \RuntimeException If the HTTP request fails.
     */
    public function execute(string $method, string $url, array $options = []): Response
    {
        $allOptions = [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => $method,
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
                $status["error"] = curl_error($this->ch);
            }

            $statusCode = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);

            if (in_array($statusCode, array_keys(Http::STATUS_MESSAGES))) {
                $status["response"] = Http::STATUS_MESSAGES[$statusCode];
            }

            return new Response($response, $statusCode, $status);
        } catch (\Throwable $e) {
            throw new \RuntimeException("HTTP request failed: " . $e->getMessage());
        } finally {
            curl_reset($this->ch);
        }
    }

    /**
     * Destructor to close the cURL handle.
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }
}
