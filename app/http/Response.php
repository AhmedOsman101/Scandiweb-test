<?php

namespace App\Http;

use App\Interfaces\HttpResponseInterface;

class Response implements HttpResponseInterface
{
    private object $response;

    public function __construct(string $data, int $statusCode, array $status)
    {
        $this->response = (object) [
            'data' => json_decode($data),
            'status' => (object) $status,
            'statusCode' => $statusCode
        ];
    }

    public function Response(): object
    {
        return $this->response;
    }

    public static function Json(
        string $status = null,
        int $status_code = null,
        array $data = null,
        array $errors = null
    ): string {
        $response = compact(
            "status",
            "status_code",
            "data",
            "errors"
        );


        foreach ($response as $key => $value) {
            if ($value === null) {
                unset($response[$key]);
            }
        }

        $status_code !== null ? http_response_code($status_code) : null;

        return json_encode($response);
    }

    public function StatusCode(): int
    {
        return $this->response->statusCode;
    }

    public function Status(): object
    {
        return $this->response->status;
    }

    public function Data(bool $json = false): object|string
    {
        if ($json) {
            return json_encode($this->response->data);
        }

        return $this->response->data;
    }
}
