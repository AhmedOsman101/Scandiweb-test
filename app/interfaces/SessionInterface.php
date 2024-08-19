<?php

namespace App\Interfaces;

/**
 * Interface SessionInterface
 *
 * Defines the contract for session management. This interface declares methods
 * for getting, setting, checking, and clearing session data.
 */
interface SessionInterface
{
  /**
   * Retrieve a value from the session.
   *
   * @param string $key The session key.
   * @param mixed $default The default value to return if the key does not exist.
   * @return mixed The value from the session or the default value.
   */
    public static function get(string $key, mixed $default = null): mixed;

  /**
   * Set a value in the session.
   *
   * @param string $key The session key.
   * @param mixed $value The value to set in the session.
   * @return void
   */
    public static function set(string $key, mixed $value): void;

  /**
   * Check if a session key exists.
   *
   * @param string $key The session key.
   * @return bool True if the key exists, false otherwise.
   */
    public static function has(string $key): bool;

  /**
   * Clear all session data.
   *
   * @return void
   */
    public static function clear(): void;
}
