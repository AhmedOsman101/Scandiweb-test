<?php

use Lib\Env;

// load environment variables on app start
Env::load(PARENT_DIRECTORY . '/.env');

// init the router
require_once PARENT_DIRECTORY . '/routes/routes.php';
