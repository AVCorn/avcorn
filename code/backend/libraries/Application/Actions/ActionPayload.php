<?php

declare(strict_types=1);

namespace App\Application\Actions;

use JsonSerializable;

/**
 * Class ActionPayload
 *
 * PHP version 8.1
 *
 * @package App\Application\Actions
 * @phpversion >= 8.1
 */
class ActionPayload implements JsonSerializable
{
    /**
     * @var array|object|null
     */
    private $data;
    private ?ActionError $error;
    private int $statusCode;

    /**
     * ActionPayload constructor.
     *
     * @param int               $statusCode The status code
     * @param array|object|null $data       The data
     * @param ActionError|null  $error      The error
     *
     * @return void
     */
    public function __construct(
        int $statusCode = 200,
        $data = null,
        ?ActionError $error = null
    ) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * Get status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get data.
     *
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get error.
     *
     * @return ActionError|null
     */
    public function getError(): ?ActionError
    {
        return $this->error;
    }

    /**
     * Convert to array to be consumed by json.
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $payload = [
            'statusCode' => $this->statusCode,
        ];

        if ($this->data !== null) {
            $payload['data'] = $this->data;
        } elseif ($this->error !== null) {
            $payload['error'] = $this->error;
        }

        return $payload;
    }
}
