<?php

namespace App\Http\Requests\Auth;

use App\DTO\Password\ForgotPasswordDTO;
use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validated data and transform it into a DTO.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return ForgotPasswordDTO
     */
    public function validated($key = null, $default = null): ForgotPasswordDTO
    {
        return new ForgotPasswordDTO(...parent::validated($key, $default));
    }
}
