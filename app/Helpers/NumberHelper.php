<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\UserTypeEnum;

class NumberHelper
{
    public static function isValidCPF($cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (11 != strlen($cpf) || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        return true;
    }

    public static function isValidCNPJ($cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (14 != strlen($cnpj) || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        return true;
    }

    public static function isPerson($cpfCnpj): int
    {
        if (11 != strlen($cpfCnpj) || preg_match('/(\d)\1{10}/', $cpfCnpj)) {
            return UserTypeEnum::COMPANY->value;
        }

        return UserTypeEnum::PERSON->value;
    }

    public static function formatCnpj($cnpj): string
    {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }
}
