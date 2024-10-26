<?php

declare(strict_types=1);

namespace App\Adapters;

use App\Enums\HttpStatusCodeEnum;

class ResponseAdapter
{
    private int $statusCode;
    private \stdClass $data;
    private string $rawData;

    public function __construct(\stdClass $response)
    {
        $this->statusCode = $response->statusCode;
        $this->rawData = $response->rawData;
        $this->data = json_decode($response->rawData) ?: new \stdClass();
    }

    public function getRawData(): string
    {
        return $this->rawData;
    }

    public function isBusinessError(): bool
    {
        return $this->statusCode >= HttpStatusCodeEnum::OK->value
               && $this->statusCode < HttpStatusCodeEnum::FAILED_DEPENDENCY->value;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): \stdClass
    {
        return $this->data;
    }

    public function getArrayData(): array
    {
        try {
            return json_decode($this->rawData, true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [];
        }
    }
}
