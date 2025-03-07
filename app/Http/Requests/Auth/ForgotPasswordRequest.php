<?php

declare(strict_types = 1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.exists' => 'Nenhum cadastro encontrado com o e-mail informado.',
        ];
    }

    /**
     * Retorna os dados validados encapsulados em um objeto Fluent.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return Fluent<string, mixed>
     */
    public function fluentParams(?string $key = null, mixed $default = null): Fluent
    {
        return new Fluent($this->validated($key, $default));
    }
}
