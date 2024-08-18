<?php

namespace App\Sessions;

use App\Interfaces\SessionInterface;

/**
 * Class Session
 *
 * A class to manage session operations such as retrieving, setting, and destroying session data.
 * Implements the SessionInterface.
 */
class Session implements SessionInterface
{
  /**
   * Retrieve a value from the session.
   *
   * @param string $key The session key.
   * @param mixed $default The default value to return if the key does not exist.
   * @return mixed The value from the session or the default value.
   */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

  /**
   * Set a value in the session.
   *
   * @param string $key The session key.
   * @param mixed $value The value to set in the session.
   * @return void
   */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

  /**
   * Check if a session key exists.
   *
   * @param string $key The session key.
   * @return bool True if the key exists, false otherwise.
   */
    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

  /**
   * Clear all session data.
   *
   * @return void
   */
    public static function flush(): void
    {
        $_SESSION = [];
    }

  /**
   * Destroy the session and clear all session data.
   *
   * This method will also remove the session cookie.
   *
   * @return void
   */
    public static function destroy(): void
    {
      // Clear all session's data
        static::flush();

      // End the current session
        session_destroy();

      // Retrieve current session cookie parameters
        $params = session_get_cookie_params();

      // Remove the session cookie by setting its expiration time in the past
        setcookie(
            name: "PHPSESSID",                  // Cookie name
            value: "",                          // Cookie value (empty to remove the cookie)
            expires_or_options: time() - 3600,  // Expire the cookie by setting its expiration time to 1 hour in the past
            path: $params['path'],              // Path on the server where the cookie is available
            domain: $params['domain'],          // Domain for which the cookie is valid
            secure: $params["secure"],          // Whether the cookie should only be sent over secure connections (HTTPS)
            httponly: $params['httponly']       // Whether the cookie is accessible only through the HTTP protocol, not JavaScript
        );
    }
}
