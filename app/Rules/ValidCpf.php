<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCpf implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove all non-numeric characters from the CPF
        $cpf = preg_replace('/[^0-9]/', '', $value);

        // Check if the CPF has 11 digits
        if (strlen($cpf) != 11) {
            return false;
        }

        // Check if all digits are the same
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validate CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'O CPF informado é inválido.';
    }
}
