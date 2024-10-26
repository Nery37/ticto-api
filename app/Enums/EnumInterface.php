<?php

declare(strict_types=1);

namespace App\Enums;

interface EnumInterface
{
    public static function toArray(): array;

    public function getTranslatedName(): string;

    public static function getById(int $id): EnumInterface;
}
