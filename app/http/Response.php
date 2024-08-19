<?php

namespace App\Http;

/**
 * Represents an HTTP response for handling HTTP requests.
 *
 * This class encapsulates the details of an HTTP response, including the response data,
 * status code, and status messages. It also provides methods to format and access the
 * response information.
 */
class Response
{
    /**
     * @var object Encapsulated response data including status and status code.
     */
    private object $response;

    /**
     * Constructs a new Response instance.
     *
     * @param string $data The response data as a JSON string.
     * @param int $statusCode The HTTP status code of the response.
     * @param array $status An associative array of status messages and other status-related information.
     */
    public function __construct(string $data, int $statusCode, array $status)
    {
        $this->response = (object) [
            'data'       => json_decode($data),
            'status'     => (object) $status,
            'statusCode' => $statusCode,
        ];
    }

    /**
     * Gets the full response object.
     *
     * @return object The response object containing data, status, and status code.
     */
    public function response(): object
    {
        return $this->response;
    }

    /**
     * Creates and echos a JSON-encoded response string.
     *
     * @param string|null $status The status message to include in the response.
     * @param int|null $statusCode The HTTP status code to include in the response.
     * @param array|null $data The data to include in the response.
     * @param array|null $errors Optional errors to include in the response.
     *
     * @return void Exits the script after execution.
     */
    public static function json(
        string $status = null,
        int $statusCode = null,
        array $data = null,
        array $errors = null,
    ): void {
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

        //? The Elvis operator `?:` returns the value on its right if the left value is falsy.
        $statusCode === null ?: http_response_code($statusCode);

        echo json_encode($response);
        exit;
    }

    /**
     * Gets the HTTP status code of the response.
     *
     * @return int The HTTP status code.
     */
    public function statusCode(): int
    {
        return $this->response?->statusCode;
    }

    /**
     * Gets the status information of the response.
     *
     * @return object The status information as an object.
     */
    public function status(): object
    {
        return $this->response?->status;
    }

    /**
     * Gets the response data.
     *
     * @param bool $json Whether to return the data as a JSON-encoded string. Defaults to false.
     *
     * @return object|string The response data as an object or a JSON-encoded string.
     */
    public function data(bool $json = false): object|string
    {
        if ($json) {
            return json_encode($this->response->data);
        }

        return $this->response->data;
    }
}
