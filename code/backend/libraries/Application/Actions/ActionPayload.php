<?php

declare(strict_types=1);

namespace App\Application\Actions;

use JsonSerializable;

class ActionPayload implements JsonSerializable
{
    private int $_statusCode;

    /**
     * @var array|object|null
     */
    private $_data;

    private ?ActionError $_error;

    public function __construct(
        int $statusCode = 200,
        $data = null,
        ?ActionError $error = null
    ) {
        $this->_statusCode = $statusCode;
        $this->_data = $data;
        $this->_error = $error;
    }

    public function getStatusCode(): int
    {
        return $this->_statusCode;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->_data;
    }

    public function getError(): ?ActionError
    {
        return $this->_error;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $payload = [
            'statusCode' => $this->_statusCode,
        ];

        if ($this->_data !== null) {
            $payload['data'] = $this->_data;
        } elseif ($this->_error !== null) {
            $payload['error'] = $this->_error;
        }

        return $payload;
    }
}
