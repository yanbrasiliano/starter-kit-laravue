<?php

namespace App\Http\Requests\Role;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        $permissions = collect($this->permissions);

        $this->merge([
            'permissions' => $permissions->has('value') ? $permissions->pluck('value')->toArray() : $permissions->toArray(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('roles', 'name')->ignore($this->role->id)],
            'description' => ['max:258'],
            'permissions' => ['array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Perfil',
            'description' => 'Descrição',
            'permissions' => 'Permissões',
        ];
    }

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

    public function fluent($key = null): Fluent
    {
        return new Fluent([
            ...parent::validated($key, $default = null),
            'guard_name' => 'web',
            'slug' => str()->slug($this->name),
        ]);
    }

}
