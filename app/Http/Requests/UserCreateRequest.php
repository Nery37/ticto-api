<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date|before:today',
            'document' => ['required', 'string', 'unique:users,document', new ValidCpf()],

            // Campos de endereço
            'address.zip_code' => 'required|string|size:8',
            'address.street' => 'required|string|max:255',
            'address.complement' => 'nullable|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|size:2',
            'address.unit' => 'nullable|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não coincide.',
            'birthdate.required' => 'A data de nascimento é obrigatória.',
            'birthdate.date' => 'A data de nascimento deve ser uma data válida.',
            'birthdate.before' => 'A data de nascimento deve ser anterior a hoje.',
            'document.required' => 'O documento é obrigatório.',
            'document.unique' => 'O documento já está em uso.',

            // Mensagens de erro para o endereço
            'address.zip_code.required' => 'O CEP é obrigatório.',
            'address.zip_code.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'address.street.required' => 'A rua é obrigatória.',
            'address.neighborhood.required' => 'O bairro é obrigatório.',
            'address.city.required' => 'A cidade é obrigatória.',
            'address.state.required' => 'O estado é obrigatório.',
            'address.state.size' => 'O estado deve ter exatamente 2 caracteres.',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nome',
            'email' => 'Email',
            'password' => 'Senha',
            'birthdate' => 'Data de Nascimento',
            'document' => 'Documento',

            // Atributos para os campos de endereço
            'address.zip_code' => 'CEP',
            'address.street' => 'Rua',
            'address.complement' => 'Complemento',
            'address.neighborhood' => 'Bairro',
            'address.city' => 'Cidade',
            'address.state' => 'Estado',
            'address.unit' => 'Unidade',
        ];
    }
}
