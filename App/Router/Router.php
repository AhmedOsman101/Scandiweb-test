<?php

namespace App\Router;

class Router
{
  private array $routes = [];

  public function add(string $method, string $uri, mixed $action, string $name = null): void
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

  public function get(string $uri, mixed $action, string $name = null): void
  {
    $this->add("GET", $uri, $action, $name);
  }

  public function post(string $uri, mixed $action, string $name = null): void
  {
    $this->add("POST", $uri, $action, $name);
  }

  public function delete(string $uri, mixed $action, string $name = null): void
  {
    $this->add("DELETE", $uri, $action, $name);
  }

  public function put(string $uri, mixed $action, string $name = null): void
  {
    $this->add("PUT", $uri, $action, $name);
  }

  public function patch(string $uri, mixed $action, string $name = null): void
  {
    $this->add("PATCH", $uri, $action, $name);
  }

  public function watch()
  {
    // Extract the current URI
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    // Current request method is determined by a hidden input
    // with the name _method or the request method header
    $request_method = $_POST["_method"] ?? $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $request_method) {
        call_user_func($route['action']);
      }
    }
  }

  public function get_route(string $name): string|null
  {
    return $this->routes[$name]['uri'] ?? null;
  }
}
