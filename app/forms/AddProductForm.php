<?php

namespace App\Forms;

use App\Enums\ProductType;
use App\Interfaces\FormInterface;
use Lib\Validator;

/**
 * Form validation class for adding a product.
 *
 * This class handles the validation logic for the product addition form, ensuring that
 * the submitted data meets the required criteria. It uses a Validator instance to perform
 * various validation checks on form fields.
 */
class AddProductForm implements FormInterface
{
    /**
     * @var Validator The validator instance used for validating form data.
     */
    protected Validator $validator;

    /**
     * Constructs a new instance of the AddProductForm class.
     *
     * Initializes the validator instance.
     */
    public function __construct()
    {
        $this->validator = new Validator();
    }


    /**
     * Validates the provided form data.
     *
     * This method performs various validation checks on the form data, including
     * string length, numeric values, enum values, and custom validation for dimensions.
     *
     * @param array $formData The form data to validate.
     *
     * @return void
     */
    public function validate(array $formData): void
    {
        extract($formData);

        $this->validator->string(
            field: "name",
            value: $name,
            min: 3,
            max: 50
        );

        $this->validator->string(
            field: "sku",
            value: $sku,
            min: 5,
            max: 50
        );

        $this->validator->float(
            field: "price",
            value: $price,
            min: 0.01,
        );

        $this->validator->inEnum(
            field: "type",
            value: $type,
            enum: ProductType::class
        );

        $this->validator->float(
            field: "weight",
            value: $weight ?? null,
            min: 0.01,
            optional: !isset($weight)
        );

        $this->validator->float(
            field: "size",
            value: $size ?? null,
            min: 0.01,
            optional: !isset($size)
        );

        $this->validator->custom(
            field: "dimensions",
            value: $dimensions ?? null,
            message: "Please provide valid dimensions for the furniture in the form of height, width and length in Centimeters",
            callback: fn($input) => (bool) preg_match("/^\d+x\d+x\d+$/", $input),
            optional: !isset($dimensions)
        );
    }

    /**
     * Retrieves the validation errors.
     *
     * This method returns an array of validation errors, if any exist.
     *
     * @return array The array of validation errors.
     */
    public function getErrors(): array
    {
        return $this->validator?->getErrors();
    }

    /**
     * Checks if there are any validation errors.
     *
     * This method returns a boolean indicating whether there are any validation errors.
     *
     * @return bool True if there are validation errors, false otherwise.
     */
    public function hasErrors(): bool
    {
        return $this->validator?->hasErrors();
    }
}
