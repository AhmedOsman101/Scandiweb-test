<?php

namespace App\Http;

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

    private static array $headers = [
        "Content-type: application/json; charset=UTF-8",
    ];

    private static Client $client;

    private function __construct()
    {
    }

    private static function getClient(): Client
    {
        if (!isset(static::$client)) {
            static::$client = Client::getInstance();
        }
        return static::$client;
    }

    public static function request(
        string $method,
        string $url,
        array $data = [],
        bool $return = true
    ): Response {
        $options = [
            'headers' => static::$headers,
            'data'    => $data,
            'return'  => $return,
        ];

        return static::getClient()->execute($method, $url, $options);
    }

    public static function get(string $url): Response
    {
        return static::request('GET', $url);
    }

    public static function post(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'POST',
            $url,
            $data,
            $return
        );
    }

    public static function put(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'PUT',
            $url,
            $data,
            $return
        );
    }

    public static function patch(string $url, array $data, bool $return = false): Response
    {
        return static::request(
            'PATCH',
            $url,
            $data,
            $return
        );
    }

    public static function delete(string $url): Response
    {
        return static::request('DELETE', $url, return: false);
    }

    public static function setHeaders(array $headers): void
    {
        static::$headers = array_merge(static::$headers, $headers);
    }
}
