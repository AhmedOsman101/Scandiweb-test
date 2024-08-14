<?php

namespace Lib;

use App\Router\Router;

/**
 * The Helpers class provides a set of utility functions globally available across the application.
 */
class Helpers
{
    protected static Router $router;

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
            var_export($item);
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
        return static::$router->get_route($name);
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
        header("Location: $uri");
        exit;
    }

    /**
     * Returns the base path for the application with a given path appended.
     *
     * @param string $path The path to append to the base path.
     * @return string The base path, with the path appended.
     */
    public static function base_path(string $path): string
    {
        return PARENT_DIRECTORY . '/' . $path;
    }

    /**
     * Sets the router instance to be used by the Helpers class.
     *
     * @param Router $router The router instance to be used.
     * @return void
     */
    public static function set_router(Router $router): void
    {
        static::$router = $router;
    }
}
