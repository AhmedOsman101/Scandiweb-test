<?php

declare(strict_types=1);

use App\Sessions\Flash;

session_start();

define('PARENT_DIRECTORY', dirname(__DIR__));


// import composer autoloader
require_once PARENT_DIRECTORY . '/vendor/autoload.php';

// bootstrap the application
require_once PARENT_DIRECTORY . "/bootstrap/bootstrap.php";

// flush any remaining flash messages
Flash::flush();
