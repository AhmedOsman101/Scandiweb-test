<?php

namespace Lib\Interfaces;

interface Middleware
{
  public function handle($request, $next);
}
