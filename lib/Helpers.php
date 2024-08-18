<?php

namespace Lib;

use App\Http\Http;
use App\Router\Router;
use ReflectionEnum;

/**
 * The Helpers class provides a set of utility functions globally available across the application.
 */
class Helpers
{
    protected static Router $router;

    //* Singletons should not be cloned nor instantiated by client.
    protected function __construct() {}

    protected function __clone() {}

    /**
     * Dumps the provided data to the browser in a formatted way then kills the script execution.
     *
     * @param mixed ...$data The data to be dumped.
     * @return void
     */
    public static function dd(...$data): void
    {
        static::dump(...$data);
        die;
    }

    /**
     * Dumps the provided data to the browser in a formatted way.
     *
     * @param mixed ...$data The data to be dumped.
     * @return void
     */
    public static function dump(...$data): void
    {
        foreach ($data as $item) {
            echo "<pre>";
            var_dump($item);
            echo "</pre>";
        }
    }

    /**
     * Returns the route URI for the given route name.
     *
     * @param string $name The name of the route.
     * @return string|null The route URI, or null if the route is not found.
     */
    public static function route(string $name): string|null
    {
        return static::$router->getRoute($name);
    }

    /**
     * Redirects the user to the specified route.
     *
     * @param string $to The name of the route to redirect to.
     * @return void
     */
    public static function redirect(string $to): void
    {
        $uri = static::route($to);
        http_response_code(Http::FOUND);
        header("Location: $uri");
        exit;
    }

    /**
     * Returns the base path for the application with a given path appended.
     *
     * @param string $path The path to append to the base path.
     * @return string The base path, with the path appended.
     */
    public static function basePath(string $path): string
    {
        return PARENT_DIRECTORY . '/' . $path;
    }

    /**
     * Sets the router instance to be used by the Helpers class.
     *
     * @param Router $router The router instance to be used.
     * @return void
     */
    public static function setRouter(Router $router): void
    {
        static::$router = $router;
    }

    public static function clean(mixed $value): mixed
    {
        return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public static function enumToAssocArray(string $enumClass): array
    {
        $reflection = new ReflectionEnum($enumClass);
        $assocArray = [];

        foreach ($reflection->getCases() as $case) {
            $assocArray[$case->name] = $case->getValue();
        }

        return $assocArray;
    }

    public static function strLimit(string $string, int $limit): string
    {
        if ($limit < strlen($string)) {
            return str_pad(
                substr(
                    $string,
                    offset: 0,
                    length: $limit - 3
                ),
                length: $limit,
                pad_string: "..."
            );
        }

        return $string;
    }
}
