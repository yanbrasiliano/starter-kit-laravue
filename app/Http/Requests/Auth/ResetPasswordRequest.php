<?php

namespace App\Http\Requests\Auth;

use App\DTO\Password\ResetPasswordDTO;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required|string',
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
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve conter no minimo 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
            'token.required' => 'O token não foi fornecido.',
            'token.string' => 'O token contém o tipo inválido.',
        ];
    }

    /**
     * Get the validated data and transform it into a DTO.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return ResetPasswordDTO
     */
    public function validated($key = null, $default = null): ResetPasswordDTO
    {
        $validated = parent::validated($key, $default);

        if (!array_key_exists('password_confirmation', $validated)) {
            $validated['password_confirmation'] = $this->input('password_confirmation');
        }

        return new ResetPasswordDTO(
            $validated['email'],
            $validated['token'],
            $validated['password'],
            $validated['password_confirmation']
        );
    }
}
