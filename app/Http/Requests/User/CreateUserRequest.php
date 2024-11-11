<?php

namespace App\Http\Requests\User;

use App\DTO\User\CreateUserDTO;
use App\Enums\{RolesEnum, StatusEnum};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $rules = [
      'name' => ['required', 'string'],
      'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id)],
      'cpf' => [
        'required',
        'string',
        new \App\Rules\ValidateCPF(),
        Rule::unique('users', 'cpf')->ignore($this->id),
      ],
      'active' => ['required', Rule::in(StatusEnum::ENABLED, StatusEnum::DISABLED)],
      'role_id' => ['required', 'exists:roles,id'],
      'send_random_password' => ['boolean'],
    ];

    !($this->send_random_password || $this->role_slug === RolesEnum::ADMINISTRATOR->value)
      ? $rules['password'] = ['required', 'min:8']
      : null;


    return $rules;
  }

  public function attributes(): array
  {
    return [
      'name' => 'Nome',
      'email' => 'E-mail',
      'password' => 'Senha',
      'role_id' => 'Perfil',
      'active' => 'Status',
      'cpf' => 'CPF',
      'registration' => 'Matrícula',
      'send_random_password' => 'Enviar senha aleatória por e-mail',
    ];
  }

  public function messages(): array
  {
    return [
      'cpf.unique' => 'CPF já cadastrado no SISTEX, realize o login com suas credenciais.',
      'email.unique' => 'O e-mail já foi cadastrado.',
      'email.email' => 'O :attribute inserido não é válido.',
      'boolean' => 'O campo :attribute não foi informado',
      'required' => 'O campo :attribute é obrigatório.',
      'exists' => 'O :attribute é inválido.',
      'max' => 'O :attribute inserido excede o limite de caracteres.',
      'unique' => 'O :attribute inserido já está em uso.',
      'in' => 'O :attribute inserido não é válido.',
      'password.min' => 'O campo Senha deve conter no mínimo 8 caracteres.',
    ];
  }

  public function validated($key = null, $default = null): CreateUserDTO|array
  {
    $validated = parent::validated();

    return new CreateUserDTO(
      ...$validated
    );
  }
}
