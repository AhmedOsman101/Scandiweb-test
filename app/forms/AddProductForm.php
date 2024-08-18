<?php

namespace App\Forms;

use App\Enums\ProductType;
use App\Interfaces\FormInterface;
use Lib\Validator;

class AddProductForm implements FormInterface
{
    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

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
            callback: function ($input) {
                $values = explode("x", $input);
                foreach ($values as $value) {
                    $this->validator->int(
                        field: "dimensions",
                        value: $value,
                        min: 1,
                    );
                }
            },
            optional: !isset($dimensions)
        );
    }
    public function getErrors(): array
    {
        return $this?->validator->getErrors();
    }

    public function hasErrors(): bool
    {
        return $this?->validator->hasErrors();
    }
}
