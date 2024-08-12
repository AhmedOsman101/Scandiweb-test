<?php

use Lib\Env;

// load environment variables on app start
Env::load(PARENT_DIRECTORY . '/.env');

// load app config
$config = require_once PARENT_DIRECTORY . '/config/config.php';

// init the router
require_once PARENT_DIRECTORY . '/routes/routes.php';
