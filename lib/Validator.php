<?php

namespace Lib;

class Validator
{
    protected array $errors = [];

    /**
     * Validates a string based on the provided parameters.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $string The string value to validate.
     * @param int $min The minimum length of the string (default is 1).
     * @param int $max The maximum length of the string (default is PHP_INT_MAX).
     * @param bool $optional Whether the field is optional (default is false).
     *
     * @return void Adds an error message to the `$errors` array if validation fails.
     */
    public function string(
        string $field,
        mixed $string,
        int $min = 1,
        int $max = PHP_INT_MAX,
        bool $optional = false
    ) {
        if ($this->optional($optional, $string)) return;

        if (!is_string($string)) {
            return $this->setError($field, "must be a string.");
        }

        $len = strlen(trim($string));

        if ($len === 0 && !$optional) {
            return $this->setError($field, "is required.");
        }

        $is_in_range =
            0 < $min    && // validate minimum is bigger than zero
            $min < $max && // validate max is bigger than min
            0 < $len    && // validate string isn't empty
            $this->between($field, $len, $min, $max); // validate the string between the requested range

        if (!$is_in_range) {
            $this->errors[$field] .= " characters long.";
        }
    }

    /**
     * Validates that a given value is between the specified minimum and maximum values.
     *
     * @param string|null $field The name of the field being validated. If
     * provided, an error message will be added to the $errors array if the
     * value is not within the specified range.
     * @param mixed $number The value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @return bool True if the value is within the specified range, false otherwise.
     */
    public function between(
        string $field,
        mixed $number,
        float $min = PHP_FLOAT_MIN,
        float $max = PHP_FLOAT_MAX,
    ): bool {
        $is_in_range = $min <= $number && $number <= $max;

        if (!$is_in_range) {
            $this->errors[$field] = "$field must be between $min and $max";

            if ($min === PHP_FLOAT_MIN || PHP_INT_MIN) {
                $this->errors[$field] = "$field must not be more than $max";
            } else if ($max === PHP_FLOAT_MAX || PHP_INT_MAX) {
                $this->errors[$field] = "$field must be at least $min";
            }
        }

        return $is_in_range;
    }


    /**
     * Validates that a given value is a float and optionally between the
     * specified minimum and maximum values.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $number The float value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @param bool $optional Whether the field is optional (default is false).
     * @return void True if the value is valid, false otherwise. This method will
     * add an error to the $errors array if the value is invalid.
     */
    public function float(
        string $field,
        mixed $number,
        float $min = PHP_FLOAT_MIN,
        float $max = PHP_FLOAT_MAX,
        bool $optional = false
    ) {

        if ($this->optional($optional, $number)) return;

        $is_float = filter_var($number, FILTER_VALIDATE_FLOAT) && true;

        if (!$is_float) {
            return $this->setError($field, "must be a decimal value.");
        }

        // check if it's between range and set errors if any.
        $this->between($field, $number, $min, $max);
    }


    /**
     * Validates that a given value is an integer and optionally between the
     * specified minimum and maximum values.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $number The integer value to validate.
     * @param int $min The minimum value (inclusive). Defaults to negative infinity.
     * @param int $max The maximum value (inclusive). Defaults to positive infinity.
     * @param bool $optional Whether the field is optional (default is false).
     * @return void True if the value is valid, false otherwise. This method will
     * add an error to the $errors array if the value is invalid.
     */
    public function int(
        string $field,
        mixed $number,
        int $min = PHP_INT_MIN,
        int $max = PHP_INT_MAX,
        bool $optional = false
    ) {

        if ($this->optional($optional, $number)) return;

        $is_int = filter_var($number, FILTER_VALIDATE_INT) && true;

        if (!$is_int) {
            // set the an error if not a integer
            return $this->setError($field, "must be an integer value.");
        }

        // check if it's between range, set errors if any and return
        $this->between($field, $number, $min, $max);
    }

    public function in_enum(string $field, mixed $value, string $enum): void
    {
        $is_valid = $enum::tryFrom($value);
        $is_valid = call_user_func([$enum, "tryFrom"], $value);

        if (!$is_valid) {
            $validValues = implode(', ', array_map(fn($case) => $case->value, call_user_func([$enum, "cases"])));
            $this->errors[$field] = "Invalid value for $field. The value must be one of the following: $validValues.";
        }
    }

    private function optional(bool $optional, mixed $value)
    {
        return ($value === null || $value === "") & $optional;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return (bool) sizeOf($this->errors);
    }

    public function getError(string $field): string|null
    {
        return $this->errors[$field] ?? null;
    }

    private function setError(string $field, string $message): void
    {
        $this->errors[$field] = ucfirst($field) . " $message";
    }
}
