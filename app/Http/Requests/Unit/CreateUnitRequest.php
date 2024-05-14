<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUnitRequest extends FormRequest
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
        return [
            'description' => ['required', 'string', 'max:150', Rule::unique('units', 'description')->ignore($this->id)],
            'acronym' => ['required', 'string', 'max:50', Rule::unique('units', 'acronym')->ignore($this->id)],

        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo descrição é obrigatório.',
            'description.max' => 'O campo descrição excede o limite de 150 caracteres.',
            'description.string' => 'O campo descrição deve ser string.',
            'description.unique' => 'A unidade já foi cadastrada.',

            'acronym.required' => 'O campo sigla é obrigatório.',
            'acronym.max' => 'O campo sigla excede o limite de 50 caracteres.',
            'acronym.string' => 'O campo sigla deve ser string.',
            'acronym.unique' => 'A sigla já está em uso.',
        ];
    }
}
