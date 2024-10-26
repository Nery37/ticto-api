<?php

declare(strict_types=1);

namespace App;

/**
 * Class Helper.
 */
class AppHelper
{
    /**
     * Convert to boolean.
     *
     * @param $boolean
     *
     * @return null|bool
     */
    public static function toBoolean($boolean): ?bool
    {
        return filter_var($boolean, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    public static function toSnakeCase($string): string
    {
        $string = preg_replace('/\s+/u', '', ucwords($string));
        return strtolower(preg_replace('/(?<!^)[A-Z]/u', '_$0', $string));
    }

    public static function onlyNumbersAsString(string $input): string
    {
        return preg_replace('/\D/', '', $input);
    }

    public static function removeSpecialCharacters($string): mixed
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $string);
    }
}
