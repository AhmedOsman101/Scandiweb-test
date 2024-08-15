<?php

declare(strict_types=1);

use App\Sessions\Flash;

define('PARENT_DIRECTORY', dirname(__DIR__));

session_start();

// import composer autoloader
require_once PARENT_DIRECTORY . '/vendor/autoload.php';

// bootstrap the application
require_once PARENT_DIRECTORY . "/bootstrap/bootstrap.php";

// flush any remaining flash messages
Flash::flush();
