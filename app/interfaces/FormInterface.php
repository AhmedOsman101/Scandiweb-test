<?php

namespace App\Interfaces;

/**
 * Interface for form validation classes.
 *
 * This interface defines the contract for form validation classes, requiring
 * methods for validating form data, retrieving validation errors, and checking
 * if there are any validation errors present.
 */
interface FormInterface
{
    /**
     * Validates the given form data.
     *
     * This method should perform validation on the provided form data. Validation rules
     * and logic should be implemented in the concrete class that implements this interface.
     *
     * @param array $formData An associative array of form data to be validated.
     *
     * @return void
     */
    public function validate(array $formData): void;

    /**
     * Retrieves validation errors.
     *
     * This method returns an array of validation errors, if any are present. If no errors
     * are found, it returns null. The exact format of the errors may vary depending on
     * the implementation.
     *
     * @return array|null An associative array of validation errors or null if no errors are found.
     */
    public function getErrors(): array|null;

    /**
     * Checks if there are validation errors.
     *
     * This method determines whether any validation errors are present.
     *
     * @return bool True if there are validation errors, otherwise false.
     */
    public function hasErrors(): bool;
}
