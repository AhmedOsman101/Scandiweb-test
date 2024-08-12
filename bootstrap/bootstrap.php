<?php

use Lib\Env;
use Lib\Helpers;

// load environment variables on app start
Env::load(Helpers::base_path(".env"));

// load app config
$config = require_once Helpers::base_path("config/config.php");

// init the router
require_once Helpers::base_path("routes/routes.php");
