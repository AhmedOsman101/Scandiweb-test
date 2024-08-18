<?php

namespace App\Http\Middleware;

use App\Interfaces\MiddlewareInterface;

/**
 * Middleware for handling CORS (Cross-Origin Resource Sharing) requests.
 *
 * This middleware sets the appropriate headers to allow cross-origin requests and handles
 * preflight OPTIONS requests by sending a 204 No Content response. It is used to enable
 * cross-origin communication between the client and server.
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Handles an incoming request and sets CORS headers.
     *
     * This method adds headers to the response to allow cross-origin requests and specifies
     * allowed HTTP methods and headers. It also handles OPTIONS requests by sending a 204
     * No Content response and terminating the request.
     *
     * @param mixed $request The incoming request.
     * @param callable $next The next middleware or request handler.
     *
     * @return mixed The response from the next middleware or request handler.
     */
    public function handle($request, $next)
    {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        return $next($request);
    }
}
