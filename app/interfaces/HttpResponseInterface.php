<?php

namespace App\Interfaces;

interface HttpResponseInterface
{
    public function Response(): object;
    public static function Json(
        string $status = null,
        int $statusCode = null,
        array $data = null,
        array $errors = null
    ): string;
    public function StatusCode(): int;
    public function Status(): object;
    public function Data(): object|string;
}
