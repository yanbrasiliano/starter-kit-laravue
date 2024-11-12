<?php

namespace Tests\Unit\DTO;

use App\DTO\Permissions\PermissionDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->id = fake('pt_BR')->randomNumber();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->guard_name = fake('pt_BR')->name();
    $this->paramsDTO->description = fake('pt_BR')->text();
    $this->paramsDTO->resource = fake('pt_BR')->text();
    $this->paramsDTO->created_at = fake('pt_BR')->date();
    $this->paramsDTO->updated_at = fake('pt_BR')->date();
});

describe('Create class name PermissionDTO', function () {
    it('PermissionDTOTest must have id, name, guard_name, description, resource, created_at and updated_at', function () {
        $roleDTO = new PermissionDTO(...(array) $this->paramsDTO);

        expect($roleDTO)->toHaveProperty('id');
        expect($roleDTO)->toHaveProperty('name');
        expect($roleDTO)->toHaveProperty('guard_name');
        expect($roleDTO)->toHaveProperty('description');
        expect($roleDTO)->toHaveProperty('resource');
        expect($roleDTO)->toHaveProperty('created_at');
        expect($roleDTO)->toHaveProperty('updated_at');

        expect($roleDTO->id)->toBe($this->paramsDTO->id);
        expect($roleDTO->name)->toBe($this->paramsDTO->name);
        expect($roleDTO->description)->toBe($this->paramsDTO->description);
        expect($roleDTO->resource)->toBe($this->paramsDTO->resource);
        expect($roleDTO->created_at)->toBe($this->paramsDTO->created_at);
        expect($roleDTO->updated_at)->toBe($this->paramsDTO->updated_at);

        expect($roleDTO->id)->toBeInt();
        expect($roleDTO->name)->toBeString();
        expect($roleDTO->description)->toBeString();
        expect($roleDTO->resource)->toBeString();
        expect($roleDTO->created_at)->toBeString();
        expect($roleDTO->updated_at)->toBeString();
    });
});
