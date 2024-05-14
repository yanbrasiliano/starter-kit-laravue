<?php

namespace App\Http\Requests\ThematicArea;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateThematicAreaRequest extends FormRequest
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
        $rules = [
            'description' => ['required', 'string', 'max:150', Rule::unique('thematic_areas', 'description')->ignore($this->id)],
        ];

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'description' => 'Descrição',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo descrição é obrigatório.',
            'unique' => 'A descrição inserida já está em uso.',
            'description.max' => 'O campo descrição excede o limite de 150 caracteres.',
            'description.string' => 'O campo descrição deve ser string.',
        ];
    }
}
