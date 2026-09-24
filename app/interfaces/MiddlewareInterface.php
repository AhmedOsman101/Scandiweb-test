<?php

namespace App\Interfaces;

/**
 * Interface for middleware handling.
 *
 * This interface defines the method required for processing an HTTP request
 * through middleware, allowing for various pre-processing and post-processing tasks.
 */
interface MiddlewareInterface {
  /**
   * @param mixed $request The incoming request.
   * @param callable $next The next middleware or request handler.
   * @return mixed The response from the next middleware or request handler.
   */
  public function handle(mixed $request, callable $next);
}
