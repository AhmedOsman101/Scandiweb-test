<?php

namespace App\Http;

use App\Interfaces\HttpResponseInterface;

class Response implements HttpResponseInterface
{
    private object $response;

    public function __construct(string $data, int $statusCode, array $status)
    {
        $this->response = (object) [
            'data'       => json_decode($data),
            'status'     => (object) $status,
            'statusCode' => $statusCode,
        ];
    }

    public function response(): object
    {
        return $this->response;
    }

    public static function json(
        string $status = null,
        int $statusCode = null,
        array $data = null,
        array $errors = null
    ): string {
        $response = compact(
            "status",
            "statusCode",
            "data",
            "errors"
        );


        foreach ($response as $key => $value) {
            if ($value === null) {
                unset($response[$key]);
            }
        }

        $statusCode !== null ? http_response_code($statusCode) : null;

        return json_encode($response);
    }

    public function statusCode(): int
    {
        return $this->response->statusCode;
    }

    public function status(): object
    {
        return $this->response->status;
    }

    public function data(bool $json = false): object|string
    {
        if ($json) {
            return json_encode($this->response->data);
        }

        return $this->response->data;
    }
}
