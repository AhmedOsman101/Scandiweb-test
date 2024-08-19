<?php

namespace Lib;

class Validator
{
    protected array $errors = [];

    /**
     * Validates a string based on the provided parameters.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The string value to validate.
     * @param int $min The minimum length of the string (default is 1).
     * @param int $max The maximum length of the string (default is PHP_INT_MAX).
     * @param bool $optional Whether the field is optional (default is false).
     *
     * @return void Adds an error message to the `$errors` array if validation fails.
     */
    public function string(
        string $field,
        mixed $value,
        int $min = 1,
        int $max = PHP_INT_MAX,
        bool $optional = false,
    ) {
        $value = trim($value);
        $isEmpty = $this->optional($field, $value, $optional);

        if ($isEmpty) {
            return;
        }

        if (!is_string($value)) {
            return $this->setError($field, "must be a string.");
        }

        $len = strlen($value);

        $is_in_range =
            0 < $min     &&  // validate minimum
            $min <= $max &&  // validate maximum
            0 < $len     &&
            $this->between($field, $len, $min, $max);

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
     * @param mixed $value The value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @return bool True if the value is within the specified range, false otherwise.
     */
    public function between(
        string $field,
        mixed $value,
        float $min = PHP_FLOAT_MIN,
        float $max = PHP_FLOAT_MAX,
    ): bool {
        $is_in_range = $min <= $value && $value <= $max;

        if (!$is_in_range) {
            $this->errors[$field] = "$field must be between $min and $max";

            // Adjust the error message when using default PHP_FLOAT_MIN or PHP_INT_MIN.
            if ($min === PHP_FLOAT_MIN || $min === PHP_INT_MIN) {
                $this->errors[$field] = "$field must not be more than $max";
            }

            // Adjust the error message when using default PHP_FLOAT_MAX or PHP_INT_MAX.
            elseif ($max === PHP_FLOAT_MAX || $max === PHP_INT_MAX) {
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
     * @param mixed $value The float value to validate.
     * @param float $min The minimum value (inclusive). Defaults to negative infinity.
     * @param float $max The maximum value (inclusive). Defaults to positive infinity.
     * @param bool $optional Whether the field is optional (default is false).
     * @return void Adds an error to the $errors array if the value is invalid.
     */
    public function float(
        string $field,
        mixed $value,
        float $min = PHP_FLOAT_MIN,
        float $max = PHP_FLOAT_MAX,
        bool $optional = false,
    ) {

        $isOptional = $this->optional($field, $value, $optional);

        if ($isOptional) {
            return;
        }

        $isFloat = filter_var($value, FILTER_VALIDATE_FLOAT) && true;

        if (!$isFloat) {
            return $this->setError($field, "must be a decimal value.");
        }

        $this->between($field, $value, $min, $max);
    }


    /**
     * Validates that a given value is an integer and optionally between the
     * specified minimum and maximum values.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The integer value to validate.
     * @param int $min The minimum value (inclusive). Defaults to negative infinity.
     * @param int $max The maximum value (inclusive). Defaults to positive infinity.
     * @param bool $optional Whether the field is optional (default is false).
     * @return void True if the value is valid, false otherwise. This method will
     * add an error to the $errors array if the value is invalid.
     */
    public function int(
        string $field,
        mixed $value,
        int $min = PHP_INT_MIN,
        int $max = PHP_INT_MAX,
        bool $optional = false,
    ) {

        $isOptional = $this->optional($field, $value, $optional);

        if ($isOptional) {
            return;
        }

        $isInteger = filter_var($value, FILTER_VALIDATE_INT) && true;

        if (!$isInteger) {
            return $this->setError($field, "must be an integer value.");
        }

        $this->between($field, $value, $min, $max);
    }

    /**
     * Validates whether the given value is one of the allowed enum cases.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The value to validate against the enum.
     * @param string $enum The enum class to validate against.
     *
     * @return void
     */
    public function inEnum(string $field, mixed $value, string $enum): void
    {
        // Validate the value against the enum cases.
        $isValid = $enum::tryFrom($value);

        if (!$isValid) {
            $validValues = implode(', ', array_map(fn($case) => $case->value, $enum::cases()));
            $this->errors[$field] = "Invalid value for $field. The value must be one of the following: $validValues.";
        }
    }

    /**
     * Performs custom validation using a callback function.
     *
     * @param string $field The name of the field being validated.
     * @param mixed $value The value to validate.
     * @param string $message The error message to set if validation fails.
     * @param callable $callback A callback function that performs the custom validation.
     * @param bool $optional Whether the field is optional or not.
     *
     * @return void
     */
    public function custom(
        string $field,
        mixed $value,
        string $message,
        callable $callback,
        bool $optional = false,
    ): void {
        $isOptional = $this->optional($field, $value, $optional);

        if ($isOptional) {
            return;
        }

        // Execute the custom validation callback and retrieve its value,
        // if the function was void assume its false.
        $result = $callback($value) ?? false;

        if (isset($this->errors[$field]) || $result === false) {
            $this->errors[$field] = $message;
        }
    }

    /**
     * Checks if a value is empty and whether the field is required.
     *
     * @param string $field The name of the field being checked.
     * @param mixed $value The value to check.
     * @param bool $optional Whether the field is optional or not.
     *
     * @return bool Returns true if the value is empty, false otherwise.
     */
    private function optional(
        string $field,
        mixed $value,
        bool $optional = false,
    ): bool {
        $isEmpty = empty($value);

        if (!$optional && $isEmpty) {
            $this->setError($field, "is required");
        }

        return $isEmpty;
    }

    /**
     * Retrieves the validation errors.
     *
     * @return array The array of validation errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Retrieves the value of a validation error.
     *
     * @return string|null The validation error if found.
     */
    public function getError(string $field): string|null
    {
        return $this->errors[$field] ?? null;
    }

    /**
     * Checks if there are any validation errors.
     *
     * @return bool Returns true if there are no validation errors, otherwise false.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Sets a validation error message for a field.
     *
     * @param string $field The name of the field that failed validation.
     * @param string $message The error message.
     */
    private function setError(string $field, string $message): void
    {
        $this->errors[$field] = ucfirst($field) . " $message";
    }
}
