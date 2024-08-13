<?php

namespace App\Router;

use App\Http\Http;
use App\Http\Response;
use Lib\Interfaces\Middleware;

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
   * Stores an array of middleware functions that will be executed for each incoming request.
   *
   * This private property holds an array of middleware functions that will be executed in the order they are added, before the main route action is executed. Middleware functions can be used to perform tasks such as authentication, logging, or input validation.
   */
  private $middlewares = [];

  /**
   * Adds a new route to the application's routing table.
   *
   * @param string $method The HTTP method for the route (e.g. 'GET', 'POST', 'DELETE', 'PUT').
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
  public function add_route(string $method, string $uri, mixed $action, string $name = null): void
  {
    if ($name) $this->routes[$name] = compact(
      'method',
      'uri',
      'action'
    );
    else $this->routes[] = compact(
      'method',
      'uri',
      'action'
    );
  }

  public function add_middleware(Middleware $middleware)
  {
    $this->middlewares[] = $middleware;
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
    $this->add_route("GET", $uri, $action, $name);
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
    $this->add_route("POST", $uri, $action, $name);
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
    $this->add_route("DELETE", $uri, $action, $name);
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
    $this->add_route("PUT", $uri, $action, $name);
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
    $this->add_route("PATCH", $uri, $action, $name);
  }

  /**
   * Adds a new OPTIONS route to the application's routing table.
   *
   * @param string $uri The URI pattern for the route.
   * @param mixed $action The callback function or action to be executed when the route is matched.
   * @param string|null $name An optional name for the route, which can be used to retrieve the route's URI later.
   * @return void
   */
  public function options(string $uri, mixed $action, string $name = null): void
  {
    $this->add_route("OPTIONS", $uri, $action, $name);
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
    $this->setCorsHeaders();
    $request = $_SERVER['REQUEST_URI'];

    if (sizeOf($this->middlewares)) {
      foreach ($this->middlewares as $middleware) {
        $middleware->handle($request, $this->match());
      }
    } else $this->match();
  }



  private function match()
  {

    // Extract the current URI
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    // Current request method is determined by a hidden input
    // with the name _method or the request method header
    $request_method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

    if ($request_method === 'OPTIONS') {
      http_response_code(204);
      exit();
    }

    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $request_method) {
        return call_user_func($route['action']);
      }
    }

    // No route matched, abort with 404 status code
    return $this->abort();
  }

  private function setCorsHeaders()
  {
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Credentials: true");
  }


  /**
   * Retrieves the URI for a named route.
   *
   * @param string $name The name of the route to retrieve.
   * @return string|null The URI for the named route, or null if the route does not exist.
   */
  public function get_route(string $name): string|null
  {
    return $this->routes[$name]['uri'] ?? null;
  }

  /**
   * Aborts the current request by setting the HTTP response code.
   *
   * @param int $status_code The HTTP status code to use for the response. Defaults to 404 Not Found.
   * @return void
   */
  public function abort(int $status_code = Http::NOT_FOUND): void
  {
    $this->setCorsHeaders();

    http_response_code($status_code);

    echo Response::Json(
      status_code: $status_code,
      status: Http::STATUS_MESSAGES[$status_code],
    );

    exit;
  }
}
