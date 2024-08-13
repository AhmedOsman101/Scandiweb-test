<?php

use Lib\Env;
use Lib\Helpers;

// load environment variables on app start
Env::load(Helpers::base_path(".env"));

// init the router
require_once Helpers::base_path("routes/routes.php");
