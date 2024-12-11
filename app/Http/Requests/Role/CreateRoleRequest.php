<?php

namespace App\Http\Requests\Role;

use App\DTO\Role\CreateRoleDTO;
use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
{
    use FailedValidation;

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
        return [
            'name' => ['required', 'string', Rule::unique('roles', 'name')->ignore($this->id)],
            'description' => ['max:258'],
            'permissions' => ['array'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Perfil',
            'description' => 'Descrição',
            'permissions' => 'Permissões',
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
            'name.required' => 'O :attribute é obrigatório.',
            'name.string' => 'O :attribute deve conter uma palavra.',
            'name.unique' => 'O :attribute inserido já está em uso.',
            'description.max' => 'A :attribute inserida excede o limite de caracteres.',
            'permissions.array' => 'O :attribute deve ser uma lista',
        ];
    }

    /**
     * Get the validated data and transform it into a DTO.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return CreateRoleDTO
     */
    public function validated($key = null, $default = null): CreateRoleDTO
    {
        /**
         * @var array<int, array<string, mixed>> $permissionsInput
         */
        $permissionsInput = is_array($this->input('permissions', [])) ? $this->input('permissions', []) : [];

        $permissions = array_map(
            fn (array $permission): string => $permission['value'] ?? '',
            $permissionsInput
        );

        $this->merge([
            'permissions' => $permissions,
        ]);

        return new CreateRoleDTO(...parent::validated($key, $default));
    }
}
