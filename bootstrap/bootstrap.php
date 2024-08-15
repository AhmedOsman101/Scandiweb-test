<?php

use App\Sessions\Flash;
use App\Sessions\Session;
use Lib\Env;
use Lib\Helpers;

// load environment variables on app start
Env::load(Helpers::base_path(".env"));

// init flash messages session key
Session::set(Flash::FLASH_KEY, []);

// init the router
require_once Helpers::base_path("routes/routes.php");
