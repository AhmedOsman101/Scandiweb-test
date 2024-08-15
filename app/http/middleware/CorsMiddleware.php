<?php

namespace App\Http\Middleware;

use App\Interfaces\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
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
