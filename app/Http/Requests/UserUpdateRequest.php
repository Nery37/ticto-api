<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $this->route('id'),
            'birthdate' => 'sometimes|date|before:today',
            'document' => ['sometimes', 'string', 'unique:users,document,' . $this->route('id'), new ValidCpf()],

            // Campos de endereço
            'address.zip_code' => 'sometimes|string|size:8',
            'address.street' => 'sometimes|string|max:255',
            'address.complement' => 'nullable|string|max:255',
            'address.neighborhood' => 'sometimes|string|max:255',
            'address.city' => 'sometimes|string|max:255',
            'address.state' => 'sometimes|string|size:2',
            'address.unit' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não coincide.',
            'birthdate.date' => 'A data de nascimento deve ser uma data válida.',
            'birthdate.before' => 'A data de nascimento deve ser anterior a hoje.',
            'document.unique' => 'O documento já está em uso.',
            'address.zip_code.size' => 'O CEP deve ter exatamente 8 dígitos.',
        ];
    }
}
