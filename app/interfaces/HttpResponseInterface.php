<?php

namespace App\Interfaces;

interface HttpResponseInterface
{
    public function response(): object;
    public static function json(
        string $status = null,
        int $statusCode = null,
        array $data = null,
        array $errors = null
    ): string;
    public function statusCode(): int;
    public function status(): object;
    public function data(): object|string;
}
