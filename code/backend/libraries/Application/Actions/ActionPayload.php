<?php

declare(strict_types=1);

namespace App\Application\Actions;

use JsonSerializable;

/**
 * Class ActionPayload
 *
 * @package App\Application\Actions
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
     * @param int $statusCode
     * @param array|object|null $data
     * @param ActionError|null $error
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
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return ActionError|null
     */
    public function getError(): ?ActionError
    {
        return $this->error;
    }

    /**
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
