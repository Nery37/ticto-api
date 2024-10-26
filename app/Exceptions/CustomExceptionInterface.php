<?php

declare(strict_types=1);

namespace App\Exceptions;

interface CustomExceptionInterface
{
    public function getTitle(): string;

    public function getSlug(): string;

    public function getDescription(): string;

    public function getStatusCode(): int;
}
