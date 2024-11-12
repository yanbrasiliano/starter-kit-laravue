<?php

namespace Tests\Unit\DTO;

use App\DTO\Role\UpdateRoleDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->id = fake('pt_BR')->randomNumber();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->description = fake('pt_BR')->text();
    $this->paramsDTO->permissions = [[]];
});

describe('Create class name UpdateRoleDTO', function () {
    it('UpdateRoleDTOTest must have name, description and permissions', function () {
        $roleDTO = new UpdateRoleDTO(...(array) $this->paramsDTO);

        expect($roleDTO)->toHaveProperty('id');
        expect($roleDTO)->toHaveProperty('name');
        expect($roleDTO)->toHaveProperty('description');
        expect($roleDTO)->toHaveProperty('permissions');

        expect($roleDTO->id)->toBe($this->paramsDTO->id);
        expect($roleDTO->name)->toBe($this->paramsDTO->name);
        expect($roleDTO->description)->toBe($this->paramsDTO->description);
        expect($roleDTO->permissions)->toBe($this->paramsDTO->permissions);

        expect($roleDTO->id)->toBeInt();
        expect($roleDTO->name)->toBeString();
        expect($roleDTO->description)->toBeString();
        expect($roleDTO->permissions)->toBeArray();
    });
});
