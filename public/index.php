<?php

declare(strict_types=1);

header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


define('PARENT_DIRECTORY', dirname(__DIR__));

// import composer autoloader
require_once PARENT_DIRECTORY . '/vendor/autoload.php';

// bootstrap the application
require_once PARENT_DIRECTORY . "/bootstrap/bootstrap.php";
