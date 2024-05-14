<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.exists' => 'Nenhum cadastro encontrado com o e-mail informado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve conter no minimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            'token.required' => 'O token não foi fornecido.',
            'token.string' => 'O token contém o tipo inválido.',
        ];
    }
}
