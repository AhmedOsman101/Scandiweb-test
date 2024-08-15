<?php

namespace App\Interfaces;

interface MiddlewareInterface
{
    public function handle($request, $next);
}
