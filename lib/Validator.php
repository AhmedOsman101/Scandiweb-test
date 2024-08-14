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
            if ($len === 0) {
                $this->errors[$field_name] = "$field_name is required";
            } else {
                $this->errors[$field_name] = "$field_name must be between $min and $max characters long";
            }
        }
    }

    /**
     * Validates that a given value is between the specified minimum and maximum values.
     *
     * @param string|null $field_name The name of the field being validated. If
     * provided, an error message will be added to the $errors array if the
     * value is not within the specified range.
     * @param float $number The value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @return bool True if the value is within the specified range, false otherwise.
     */
    public function between(string $field_name = null, float $number, float $min = -INF, float $max = INF): bool
    {
        $is_between_range = $min <= $number && $number <= $max;

        if (!$is_between_range && $field_name) {
            $this->errors[$field_name] = "$field_name must be between $min and $max";

            if ($min === -INF) {
                $this->errors[$field_name] = "$field_name must not be bigger than $max";
            } else if ($max === INF) {
                $this->errors[$field_name] = "$field_name must be at least $min";
            }
        }

        return $is_between_range;
    }


    /**
     * Validates that a given value is a float and optionally between the
     * specified minimum and maximum values.
     *
     * @param string $field_name The name of the field being validated.
     * @param float $number The float value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @return bool True if the value is valid, false otherwise. This method will
     * add an error to the $errors array if the value is invalid.
     */
    public function float(string $field_name, float $number, float $min = -INF, float $max = INF): bool
    {
        $is_float = filter_var($number, FILTER_VALIDATE_FLOAT) && true;

        if (!$is_float) {
            // set the an error if not a float
            $this->errors[$field_name] = "$field_name must be a decimal value";
            // early return
            return false;
        }

        // check if it's between range, set errors if any then return
        return static::between($field_name, $number, $min, $max);
    }


    /**
     * Validates that a given value is an integer and optionally between the
     * specified minimum and maximum values.
     *
     * @param string $field_name The name of the field being validated.
     * @param int $number The integer value to validate.
     * @param int $min The minimum value (inclusive). Defaults to negative infinity.
     * @param int $max The maximum value (inclusive). Defaults to positive infinity.
     * @return bool True if the value is valid, false otherwise. This method will
     * add an error to the $errors array if the value is invalid.
     */
    public function int(string $field_name, int $number, int $min = -INF, int $max = INF): bool
    {
        $is_int = filter_var($number, FILTER_VALIDATE_INT) && true;

        if (!$is_int) {
            // set the an error if not a integer
            $this->errors[$field_name] = "$field_name must be an integer value";
            // early return
            return false;
        }

        // check if it's between range, set errors if any and return
        return static::between($field_name, $number, $min, $max);
    }
}
