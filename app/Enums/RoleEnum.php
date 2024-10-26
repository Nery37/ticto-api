<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: int implements EnumInterface
{
    case EMPLOYEE = 1;
    case ADMINISTRATOR = 2;

    public static function toArray(): array
    {
        return [
            RoleEnum::EMPLOYEE,
            RoleEnum::ADMINISTRATOR,
        ];
    }

    public function getTranslatedName(): string
    {
        return match ($this) {
            RoleEnum::EMPLOYEE => 'Funcionário',
            RoleEnum::ADMINISTRATOR => 'Administrador',
        };
    }

    public static function getById(int $id): EnumInterface
    {
        return match ($id) {
            RoleEnum::EMPLOYEE->value => RoleEnum::EMPLOYEE,
            RoleEnum::ADMINISTRATOR->value => RoleEnum::ADMINISTRATOR,
        };
    }
}
