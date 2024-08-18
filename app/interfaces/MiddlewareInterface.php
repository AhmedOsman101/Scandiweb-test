<?php

namespace App\Interfaces;

/**
 * Interface for middleware handling.
 *
 * This interface defines the method required for processing an HTTP request
 * through middleware, allowing for various pre-processing and post-processing tasks.
 */
interface MiddlewareInterface
{
    public function handle($request, $next);
}
