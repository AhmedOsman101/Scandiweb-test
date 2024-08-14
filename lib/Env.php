<?php

namespace Lib;

class Env
{
  /**
   * Load environment variables from .env file
   * @param string $path
   * @return void
   */
    public static function load(string $path)
    {
      // read the .env file as one line and ignoring empty lines
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
          // ignore comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

          // separate key value pairs using '='
          // then assigning the keys to name and values to value
            [$key, $value] = explode('=', $line, 2);

          // trims whitespaces and removing quotes (single & double)
            $key = str_replace(['"', "'"], '', trim($key));
            $value = str_replace(['"', "'"], '', trim($value));

          // if this variable does not exist in neither the $_SERVER nor the $_ENV superglobals
          // then append it to the $_ENV and $_SERVER
            if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                static::set($key, $value);
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $_SERVER[$default] ?? $default;
    }

    public static function set(string $key, int|bool|string|null $value = null): void
    {
        if (is_numeric($value)) {
            $value = (int) $value;
        }
        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
