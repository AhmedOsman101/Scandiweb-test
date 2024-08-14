<?php

namespace App\Interfaces;

interface Middleware
{
  public function handle($request, $next);
}
