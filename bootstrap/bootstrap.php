<?php

use Lib\Env;
use Lib\Helpers;

// load environment variables on app start
Env::load(Helpers::basePath(".env"));

// init the router
require_once Helpers::basePath("routes/routes.php");
