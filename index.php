<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

// bootstrap the application
require_once __DIR__ . "/bootstrap/bootstrap.php";
// bootstrap the application
require_once __DIR__ . "/router.php";


// Now you can access the values using getenv() or $_ENV

echo "<pre>";
var_export($_ENV);
echo "</pre>";
