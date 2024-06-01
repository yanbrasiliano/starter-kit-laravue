<?php

namespace App\Http\Requests\Role;

use App\DTO\Paginate\CustomPaginateParamsDTO;
use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class RoleIndexRequest extends FormRequest
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
      'sortBy' => ['sometimes', 'string'],
      'search' => ['sometimes', 'string'],
      'page' => ['sometimes', 'integer'],
      'rowsPerPage' => ['sometimes', 'integer'],
      'descending' => ['sometimes', 'boolean'],
      'rowsNumber' => ['sometimes', 'integer'],
    ];
  }

  public function attributes()
  {
    return [
      'sortBy' => 'Organizar por',
      'search' => 'Termo',
      'page' => 'Página',
      'perPage' => 'Itens por página',
      'descending' => 'Ordem',
      'rowsNumber' => 'Número de linhas',
    ];
  }

  public function messages()
  {
    return [
      'sortBy.string' => 'A :attribute deve ser uma palavra',
      'page.integer' => 'A :attributo deve ser um número',
      'perPage.integer' => ':attribute deve ser um número',
      'search.string' => 'O :attribute deve ser uma palavra',
      'ascending:boolean' => 'A :attribute deve ser verdadeiro ou falso',
      'rowsNumber.integer' => 'O :attribute deve ser um número',
    ];
  }

  protected function prepareForValidation()
  {
    $this->merge([
      'descending' => $this->toBoolean($this->descending),
    ]);
  }

  private function toBoolean($booleable)
  {
    return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
  }

  public function validated($key = null, $default = null): CustomPaginateParamsDTO|array
  {
    return new CustomPaginateParamsDTO(...$this->toArray());
  }
}
