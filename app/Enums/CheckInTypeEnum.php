<?php

declare(strict_types=1);

namespace App\Enums;

enum CheckInTypeEnum: int implements EnumInterface
{
    case CHECK_IN = 1;
    case CHECK_OUT = 2;

    public static function toArray(): array
    {
        return [
            CheckInTypeEnum::CHECK_IN,
            CheckInTypeEnum::CHECK_OUT,
        ];
    }

    public function getTranslatedName(): string
    {
        return match ($this) {
            CheckInTypeEnum::CHECK_IN => 'Entrada',
            CheckInTypeEnum::CHECK_OUT => 'Saída',
        };
    }

    public static function getById(int $id): EnumInterface
    {
        return match ($id) {
            CheckInTypeEnum::CHECK_IN->value => CheckInTypeEnum::CHECK_IN,
            CheckInTypeEnum::CHECK_OUT->value => CheckInTypeEnum::CHECK_OUT,
        };
    }
}
