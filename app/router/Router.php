<?php

namespace App\Router;

use App\Http\Http;
use App\Controllers\Controller;

/**
 * The Router class is responsible for managing the application's routing table and handling incoming requests.
 *
 * The Router class provides methods for adding routes to the routing table, including GET, POST, DELETE, PUT, and PATCH routes.
 * It also includes a `watch()` method that is responsible for matching the current request URI and HTTP method to a registered route, and invoking the corresponding action callback.
 * The Router class also includes methods for retrieving the URI for a named route, and for aborting the current request with a specified HTTP status code.
 */
class Router
{
  /**
   * Stores the application's routing table.
   *
   * This private property holds an array of route definitions, where each route is represented as an associative array with keys for the HTTP method, URI pattern, and action callback.
   */
    private array $routes = [];

  /**
   * Adds a new route to the application's routing table.
   *
   * @param string $method The HTTP method for the route (e.g. 'GET', 'POST', 'DELETE', 'PUT').
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string $name A name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function addRoute(string $method, string $uri, mixed $action, string $name): void
    {
        $this->routes[$name] = compact(
            'method',
            'uri',
            'action'
        );
    }

  /**
   * Retrieves the URI for a named route.
   *
   * @param string $name The name of the route to retrieve.
   * @return string|null The URI for the named route, or null if the route does not exist.
   */
    public function getRoute(string $name): string|null
    {
        return $this->routes[$name]['uri'] ?? null;
    }

  /**
   * Adds a new GET route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function get(string $uri, mixed $action, string $name = null): void
    {
        $this->addRoute("GET", $uri, $action, $name);
    }

  /**
   * Adds a new POST route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function post(string $uri, mixed $action, string $name = null): void
    {
        $this->addRoute("POST", $uri, $action, $name);
    }

  /**
   * Adds a new DELETE route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function delete(string $uri, mixed $action, string $name = null): void
    {
        $this->addRoute("DELETE", $uri, $action, $name);
    }

  /**
   * Adds a new PUT route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function put(string $uri, mixed $action, string $name = null): void
    {
        $this->addRoute("PUT", $uri, $action, $name);
    }

  /**
   * Adds a new PATCH route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
    public function patch(string $uri, mixed $action, string $name = null): void
    {
        $this->addRoute("PATCH", $uri, $action, $name);
    }

  /**
   * Handles the routing logic for the application.
   *
   * This method is responsible for extracting the current URI and request method,
   * and then iterating through the registered routes to find a match. If a match
   * is found, the corresponding action callback is invoked. If no route matches,
   * the `abort()` method is called to handle the 404 error.
   */
    public function watch()
    {

        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];


        // Current request method is determined by a hidden input named `_method` or the request method header
        $requestMethod = $_REQUEST["_method"] ?? $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $requestMethod) {
                return call_user_func($route['action']);
            }
        }

        return static::abort();
    }


  /**
   * Aborts the current request by setting the HTTP response code.
   *
   * @param int $statusCode The HTTP status code to use for the response. Defaults to 404 Not Found.
   * @return void
   */
    public static function abort(int $statusCode = Http::NOT_FOUND): void
    {
        http_response_code($statusCode);

        Controller::view("errors/$statusCode");

        exit;
    }
}
