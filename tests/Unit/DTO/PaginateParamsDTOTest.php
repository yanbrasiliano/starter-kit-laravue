<?php

namespace Tests\Unit\DTO;

use App\DTO\Paginate\PaginateParamsDTO;
use stdClass;

beforeEach(function () {
  $this->paramsDto = new stdClass();
  $this->paramsDto->limit = fake('pt_BR')->randomNumber();
  $this->paramsDto->page = fake('pt_BR')->randomNumber();
  $this->paramsDto->order = fake('pt_BR')->randomElement(['asc', 'desc']);
  $this->paramsDto->column = fake('pt_BR')->randomElement([
    'name', 'email', 'role', '',
  ]);
  $this->paramsDto->search = fake('pt_BR')->text();
});

describe('Create class name PaginateParamsDTO', function () {
  it('CreateUserDTO must have limit, page, order, column and search', function () {
    $paginateParamsDTO = new PaginateParamsDTO(...(array) $this->paramsDto);

    expect($paginateParamsDTO)->toHaveProperty('limit');
    expect($paginateParamsDTO)->toHaveProperty('page');
    expect($paginateParamsDTO)->toHaveProperty('order');
    expect($paginateParamsDTO)->toHaveProperty('column');
    expect($paginateParamsDTO)->toHaveProperty('search');

    expect($paginateParamsDTO->limit)->toBe($this->paramsDto->limit);
    expect($paginateParamsDTO->page)->toBe($this->paramsDto->page);
    expect($paginateParamsDTO->order)->toBe($this->paramsDto->order);
    expect($paginateParamsDTO->column)->toBe($this->paramsDto->column);
    expect($paginateParamsDTO->search)->toBe($this->paramsDto->search);

    expect($paginateParamsDTO->limit)->toBeInt();
    expect($paginateParamsDTO->page)->toBeInt();
    expect($paginateParamsDTO->order)->toBeString();
    expect($paginateParamsDTO->column)->toBeString();
    expect($paginateParamsDTO->search)->toBeString();
  });
});
