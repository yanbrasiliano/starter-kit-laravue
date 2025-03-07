<?php

declare(strict_types = 1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name' => '',
            'limit' => $this->get('limit', 10),
            'page' => $this->get('page', 1),
            'order' => $this->get('order', 'desc'),
            'column' => $this->get('column', 'id'),
            'search' => $this->get('search', ''),
            'paginated' => $this->get('paginated', 1),
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
            'name' => ['sometimes', 'string'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'column' => ['sometimes', 'string', 'in:id,name,email,cpf'],
            'order' => ['sometimes', 'string', 'in:asc,desc'],
            'search' => ['sometimes', 'string', 'nullable'],
            'paginated' => ['sometimes', 'integer', 'in:0,1'],
        ];
    }
}
