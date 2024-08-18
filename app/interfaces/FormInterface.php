<?php

namespace App\Interfaces;

interface FormInterface
{
    public function validate(array $formData): void;
    public function getErrors(): array|null;
    public function hasErrors(): bool;
}
