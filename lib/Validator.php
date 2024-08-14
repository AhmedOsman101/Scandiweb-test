<?php

namespace Lib;

class Validator
{

  protected array $errors = [];

  /**
   * Validates that a given string is between the specified minimum and maximum lengths.
   *
   * @param string $field_name The name of the field being validated.
   * @param string $string The string to validate.
   * @param int $min The minimum length of the string (inclusive).
   * @param int $max The maximum length of the string (inclusive).
   * @return void This method does not return a value, but will add an error to the $errors array if the string is invalid.
   */
  public function string(string $field_name, string $string, int $min = 1, int $max = INF): void
  {
    $len = strlen(trim($string));

    $is_valid =
      0 < $min    && // validate minimum is bigger than zero
      $min < $max && // validate max is bigger than min
      0 < $len    && // validate string isn't empty
      static::between($len, $min, $max); // validate the string between the requested range

    if (!$is_valid) {
      $this->errors[$field_name] =
        ($len === 0)
        ? "$field_name is required"
        : "$field_name must be between $min and $max";
    }
  }

  /**
   * Checks if a given value is between the specified minimum and maximum values.
   *
   * @param float $value The value to check.
   * @param float $min The minimum value (inclusive).
   * @param float $max The maximum value (inclusive). Defaults to positive infinity.
   * @return bool True if the value is between the minimum and maximum, false otherwise.
   */
  public static function between(float $value, float $min, float $max = INF): bool
  {
    return $min <= $value && $value <= $max;
  }
}
