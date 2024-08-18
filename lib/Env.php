<?php

namespace Lib;

class Env
{
  /**
   * Loads environment variables from a .env file.
   *
   * @param string $path Path to the .env file.
   * @return void
   * @throws \RuntimeException If the .env file cannot be found or read.
   */
    public static function load(string $path)
    {
        try {
          // Attempt to read the .env file, ignoring empty lines
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if ($lines === false) {
                throw new \RuntimeException("Failed to read the .env file at $path.");
            }

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
        } catch (\Exception $e) {
            throw new \RuntimeException("Error loading .env file: " . $e->getMessage());
        }
    }

  /**
   * Get the value of an environment variable.
   *
   * @param string $key The environment variable name.
   * @param mixed $default Default value if the environment variable is not set.
   * @return mixed
   */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $_SERVER[$default] ?? $default;
    }

  /**
   * Set an environment variable.
   *
   * @param string $key The environment variable name.
   * @param int|bool|string|null $value The value to set.
   * @return void
   */
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
