<?php

use App\Interfaces\SessionInterface;

/**
 * Class Flash
 *
 * A session-based flash message handler that implements the SessionInterface.
 * Stores and retrieves flash messages in the session under a specific key.
 */
class Flash implements SessionInterface
{
  /**
   * The key used to store flash messages in the session.
   *
   * @var string
   */
  protected const FLASH_KEY = "_flash";

  /**
   * Retrieve a flash message from the session.
   *
   * @param string $key The key for the flash message.
   * @param mixed $default The default value to return if the flash message does not exist.
   * @return mixed The flash message from the session or the default value.
   */
  public static function get(string $key, mixed $default = null): mixed
  {
    return $_SESSION[self::FLASH_KEY][$key] ?? $default;
  }

  /**
   * Set a flash message in the session.
   *
   * @param string $key The key for the flash message.
   * @param mixed $value The flash message value to store.
   * @return void
   */
  public static function set(string $key, mixed $value): void
  {
    $_SESSION[self::FLASH_KEY][$key] = $value;
  }

  /**
   * Check if a flash message exists in the session.
   *
   * @param string $key The key for the flash message.
   * @return bool True if the flash message exists, false otherwise.
   */
  public static function has(string $key): bool
  {
    return array_key_exists($key, $_SESSION[self::FLASH_KEY]);
  }

  /**
   * Clear all flash messages from the session.
   *
   * @return void
   */
  public static function flush(): void
  {
    $_SESSION[self::FLASH_KEY] = [];
  }
}
