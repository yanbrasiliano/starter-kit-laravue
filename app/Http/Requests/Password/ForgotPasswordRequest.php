<?php

namespace App\Http\Requests\Password;

use App\DTO\Password\ForgotPasswordDTO;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.exists' => 'Nenhum cadastro encontrado com o e-mail informado.',
        ];
    }

    public function validated($key = null, $default = null): array | ForgotPasswordDTO
    {
        return new ForgotPasswordDTO(...parent::validated($key, $default));
    }
}
