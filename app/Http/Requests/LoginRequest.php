<?php

namespace App\Http\Requests;

use App\DTO\Authenticate\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string',
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
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
        ];
    }

    /**
     * Get the validated data and transform it into a DTO.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return LoginDTO
     */
    public function validated($key = null, $default = null): LoginDTO
    {
        return new LoginDTO(...parent::validated($key, $default));
    }
}
