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
    /**
     * @var Router The router instance used for route management.
     */
    protected static Router $router;

    //* Singletons should not be cloned nor instantiated by client.
    protected function __construct()
    {
    }

    protected function __clone()
    {
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
     * Dumps the provided data to the browser in a formatted way and terminates the script execution.
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
     * Retrieves the URI for a given route name.
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
        if ($uri === null) {
            static::$router::abort();
        }

        $uri = static::route($to);
        http_response_code(Http::FOUND);
        header("Location: $uri");
        exit;
    }

    /**
     * Returns the base path for the application with a given path appended.
     *
     * @param string $path The path to append to the base path.
     * @return string The full path.
     */
    public static function basePath(string $path): string
    {
        // Trimmed the path to avoid duplicate slashes in the concatenated path.
        return PARENT_DIRECTORY . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Sets the router instance to be used by the Helpers class.
     *
     * @param Router $router The router instance to set.
     * @return void
     */
    public static function setRouter(Router $router): void
    {
        static::$router = $router;
    }

    /**
     * Sanitizes a given value by removing special characters.
     *
     * @param mixed $value The value to sanitize.
     * @return mixed The sanitized value.
     */
    public static function clean(mixed $value): mixed
    {
        return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * Converts an enum class to an associative array where keys are case names and values are case values.
     *
     * @param string $enumClass The fully qualified name of the enum class.
     * @return array The associative array representation of the enum.
     * @throws \ReflectionException If the class does not exist or is not an enum.
     */
    public static function enumToAssocArray(string $enumClass): array
    {
        $reflection = new ReflectionEnum($enumClass);
        $assocArray = [];

        foreach ($reflection->getCases() as $case) {
            $assocArray[$case->getName()] = $case->getValue();
        }

        return $assocArray;
    }

    /**
     * Truncates a string to a specified length and appends ellipsis if necessary.
     *
     * @param string $string The string to truncate.
     * @param int $limit The maximum length of the truncated string including ellipsis.
     * @return string The truncated string.
     */
    public static function strLimit(string $string, int $limit): string
    {
        // Used mb_strlen and mb_substr for multi-byte string support.
        if (mb_strlen($string) > $limit) {
            return mb_substr($string, 0, $limit - 3) . '...';
        }

        return $string;
    }
}
