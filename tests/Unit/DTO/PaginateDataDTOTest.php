<?php

namespace Tests\Unit\DTO;

use App\DTO\Paginate\PaginateDataDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->current_page = fake('pt_BR')->randomNumber();
    $this->paramsDTO->data = [];
    $this->paramsDTO->first_page_url = fake('pt_BR')->url();
    $this->paramsDTO->from = fake('pt_BR')->randomNumber();
    $this->paramsDTO->last_page = fake('pt_BR')->randomNumber();
    $this->paramsDTO->links = [];
    $this->paramsDTO->next_page_url = fake('pt_BR')->url();
    $this->paramsDTO->path = fake('pt_BR')->url();
    $this->paramsDTO->last_page_url = fake('pt_BR')->url();
    $this->paramsDTO->per_page = fake('pt_BR')->randomNumber();
    $this->paramsDTO->prev_page_url = fake('pt_BR')->url();
    $this->paramsDTO->to = fake('pt_BR')->randomNumber();
    $this->paramsDTO->total = fake('pt_BR')->randomNumber();
});

describe('Create class name PaginateDataDTO', function () {
    it('PaginateDataDTO must have current_page, data, first_page_url, from, last_page,
     links, next_page_url, path, last_page_url, per_page, prev_page_url, to and total', function () {
        $userDTO = new PaginateDataDTO(...(array) $this->paramsDTO);

        expect($userDTO)->toHaveProperty('current_page');
        expect($userDTO)->toHaveProperty('data');
        expect($userDTO)->toHaveProperty('first_page_url');
        expect($userDTO)->toHaveProperty('from');
        expect($userDTO)->toHaveProperty('last_page');
        expect($userDTO)->toHaveProperty('links');
        expect($userDTO)->toHaveProperty('next_page_url');
        expect($userDTO)->toHaveProperty('path');
        expect($userDTO)->toHaveProperty('last_page_url');
        expect($userDTO)->toHaveProperty('per_page');
        expect($userDTO)->toHaveProperty('prev_page_url');
        expect($userDTO)->toHaveProperty('to');
        expect($userDTO)->toHaveProperty('total');

        expect($userDTO->current_page)->toBe($this->paramsDTO->current_page);
        expect($userDTO->data)->toBe($this->paramsDTO->data);
        expect($userDTO->first_page_url)->toBe($this->paramsDTO->first_page_url);
        expect($userDTO->from)->toBe($this->paramsDTO->from);
        expect($userDTO->last_page)->toBe($this->paramsDTO->last_page);
        expect($userDTO->links)->toBe($this->paramsDTO->links);
        expect($userDTO->next_page_url)->toBe($this->paramsDTO->next_page_url);
        expect($userDTO->path)->toBe($this->paramsDTO->path);
        expect($userDTO->last_page_url)->toBe($this->paramsDTO->last_page_url);
        expect($userDTO->per_page)->toBe($this->paramsDTO->per_page);
        expect($userDTO->prev_page_url)->toBe($this->paramsDTO->prev_page_url);
        expect($userDTO->to)->toBe($this->paramsDTO->to);
        expect($userDTO->total)->toBe($this->paramsDTO->total);

        expect($userDTO->current_page)->toBeInt();
        expect($userDTO->data)->toBeArray();
        expect($userDTO->first_page_url)->toBeString();
        expect($userDTO->from)->toBeInt();
        expect($userDTO->last_page)->toBeInt();
        expect($userDTO->links)->toBeArray();
        expect($userDTO->next_page_url)->toBeString();
        expect($userDTO->path)->toBeString();
        expect($userDTO->last_page_url)->toBeString();
        expect($userDTO->per_page)->toBeInt();
        expect($userDTO->prev_page_url)->toBeString();
        expect($userDTO->to)->toBeInt();
        expect($userDTO->total)->toBeInt();
    });
});
