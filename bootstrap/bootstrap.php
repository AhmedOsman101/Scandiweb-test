<?php

// init the router
require_once PARENT_DIRECTORY . '/Router/router.php';

/**
 * Load environment variables from .env file
 * @param string $path
 * @return void
 */
function loadEnv(string $path)
{
  // read the .env file as one line and ignoring empty lines
  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    // ignore comments
    if (strpos(trim($line), '#') === 0) continue;

    // separate key value pairs using '='
    // then assigning the keys to name and values to value
    [$name, $value] = explode('=', $line, 2);

    // trims whitespaces and removing quotes (single & double)
    $name = str_replace(['"', "'"], '', trim($name));
    $value = str_replace(['"', "'"], '', trim($value));

    // if the value was numeric convert into an integer for convenience
    if (is_numeric($value)) $value = (int) $value;

    // if this variable does not exist in neither the $_SERVER nor the $_ENV
    // superglobals then append it to the $_ENV and $_SERVER
    if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
      putenv(sprintf('%s=%s', $name, $value));
      $_ENV[$name] = $value;
      $_SERVER[$name] = $value;
    }
  }
}

// load environment variables on app start
loadEnv(PARENT_DIRECTORY . '/.env');
