<?php

namespace App\Http;

/**
 * HTTP utility class for managing HTTP requests and responses.
 *
 * This class provides static methods for making HTTP requests (GET, POST, PUT, PATCH, DELETE)
 * and managing HTTP headers. It also defines HTTP status codes and their corresponding messages.
 */
class Http
{
    public const int OK                    = 200;
    public const int CREATED               = 201;
    public const int NO_CONTENT            = 204;
    public const int FOUND                 = 302;
    public const int BAD_REQUEST           = 400;
    public const int UNAUTHORIZED          = 401;
    public const int FORBIDDEN             = 403;
    public const int NOT_FOUND             = 404;
    public const int METHOD_NOT_ALLOWED    = 405;
    public const int UNPROCESSABLE_CONTENT = 422;
    public const int INTERNAL_SERVER_ERROR = 500;
    public const int SERVICE_UNAVAILABLE   = 503;

    /**
     * @var array Mapping of HTTP status codes to their messages.
     */
    public const array STATUS_MESSAGES = [
        self::OK                    => 'OK',
        self::CREATED               => 'Created',
        self::NO_CONTENT            => 'No Content',
        self::FOUND                 => 'Redirect',
        self::BAD_REQUEST           => 'Bad Request',
        self::UNAUTHORIZED          => 'Unauthorized',
        self::FORBIDDEN             => 'Forbidden',
        self::NOT_FOUND             => 'Resource Not Found',
        self::METHOD_NOT_ALLOWED    => 'Method Not Allowed',
        self::UNPROCESSABLE_CONTENT => 'Unprocessable Entity',
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::SERVICE_UNAVAILABLE   => 'Service Unavailable',
    ];

    /**
     * @var array Default headers for HTTP requests.
     */
    private static array $headers = [
        "Content-type: application/json; charset=UTF-8",
    ];

    /**
     * @var Client HTTP client instance for making requests.
     */
    private static Client $client;


    //* Singletons should not be cloned nor instantiated by client.
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Gets the HTTP client instance.
     *
     * @return Client The HTTP client instance.
     */
    private static function getClient(): Client
    {
        if (!isset(static::$client)) {
            static::$client = Client::getInstance();
        }
        return static::$client;
    }

    /**
     * Makes an HTTP request.
     *
     * @param string $method The HTTP method (e.g., GET, POST, PUT, PATCH, DELETE).
     * @param string $url The URL for the request.
     * @param array $data Optional data to send with the request.
     * @param bool $return Whether to return the response content.
     *
     * @return Response The HTTP response.
     */
    public static function request(
        string $method,
        string $url,
        array $data = [],
        bool $return = true,
    ): Response {
        $options = [
            'headers' => static::$headers,
            'data'    => $data,
            'return'  => $return,
        ];

        return static::getClient()->execute($method, $url, $options);
    }

    /**
     * Makes an HTTP GET request.
     *
     * @param string $url The URL for the request.
     *
     * @return Response The HTTP response.
     */
    public static function get(string $url): Response
    {
        return static::request('GET', $url);
    }

    /**
     * Makes an HTTP POST request.
     *
     * @param string $url The URL for the request.
     * @param array $data Data to send with the request.
     * @param bool $return Whether to return the response content.
     *
     * @return Response The HTTP response.
     */
    public static function post(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'POST',
            $url,
            $data,
            $return
        );
    }

    /**
     * Makes an HTTP PUT request.
     *
     * @param string $url The URL for the request.
     * @param array $data Data to send with the request.
     * @param bool $return Whether to return the response content.
     *
     * @return Response The HTTP response.
     */
    public static function put(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'PUT',
            $url,
            $data,
            $return
        );
    }

    /**
     * Makes an HTTP PATCH request.
     *
     * @param string $url The URL for the request.
     * @param array $data Data to send with the request.
     * @param bool $return Whether to return the response content.
     *
     * @return Response The HTTP response.
     */
    public static function patch(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'PATCH',
            $url,
            $data,
            $return
        );
    }

    /**
     * Makes an HTTP DELETE request.
     *
     * @param string $url The URL for the request.
     *
     * @return Response The HTTP response.
     */
    public static function delete(string $url): Response
    {
        return static::request('DELETE', $url, return: false);
    }

    /**
     * Sets or adds headers for HTTP requests.
     *
     * @param array $headers An array of headers to set.
     *
     * @return void
     */
    public static function setHeaders(array $headers): void
    {
        static::$headers = array_merge(static::$headers, $headers);
    }
}
