<?php

namespace App\Http\Requests\User;

use App\Enums\StatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->id)],
            'active' => ['required', Rule::in(StatusEnum::ENABLED, StatusEnum::DISABLED)],
            'role_id' => ['required', 'exists:roles,id'],
        ];

        if (isset($this->password)) {
            $rules = array_merge($rules, [
                'password' => ['required', 'min:8'],
            ]);
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nome',
            'role_id' => 'Perfil',
            'active' => 'Status',
            'email' => 'E-mail',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'exists' => 'O :attribute é inválido.',
            'max' => 'O :attribute inserido excede o limite de caracteres.',
            'unique' => 'O :attribute inserido já está em uso.',
            'email' => 'O :attribute inserido não é válido.',
            'string' => 'O :attribute contém um tipo inválido',
            'in' => 'O :attribute inserido não é válido.',
            'password.min' => 'O campo Senha deve conter no minimo 8 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
